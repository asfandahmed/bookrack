<?php
class Linked_List{
	protected  $CI;
    public $cypher;
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('neo');
	}

	public function add($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $key_value_pairs)
    {
    	$key_pair_str="";
    	$properties = array_keys($key_value_pairs);
    	$count = count($properties);
    	foreach ($properties as $key => $property) {
    		$key_pair_str .= $property . ":{" . $property . "}";
    		if(!($key === $count-1)){
    			$key_pair_str .= ", ";
    		}
    	}

		$this->cypher  = "MATCH (" . $parent_node_label . " { " . $parent_node_key . ": {" . $parent_node_key . "}}) ";
		$this->cypher .= "OPTIONAL MATCH (node)-[r:CURRENT" . strtoupper($list_node_label) . "]->(currentnode) ";
		$this->cypher .= "DELETE r ";
		$this->cypher .= "CREATE (node)-[:CURRENT" . strtoupper($list_node_label) . "]->(m:" . $list_node_label . " { " . $key_pair_str . " }) ";
		$this->cypher .= "WITH m, collect(currentnode) as currentnode ";
		$this->cypher .= "FOREACH (x IN currentnode | CREATE m-[:NEXT" . strtoupper($list_node_label) . "]->x) ";
		$this->cypher .= "RETURN m";

		$key_value_pairs[$parent_node_key] = $parent_node_value;
        $node = $this->CI->neo->execute_query($this->cypher, $key_value_pairs);
        return $node; 
    }

    /**
     * Delete content and create relationships between remaining content as appropriate
     */
	public function delete($statusId, $commentId)
    {
        $this->cypher = $this->get_delete_cypher($email, $statusId);

        $params = array(
            'commentId' => $commentId,
            'statusId' => $statusId,
        );

        $this->CI->neo->execute_query($this->cypher, $params);
    }

    /**
     * Gets the appropriate DELETE query based on where in the list the Content appears
     * @return string Cypher query to delete Content
     */
	protected function get_delete_cypher($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_key, $list_node_value)
    {
        $REL = strtoupper($parent_node_label);
        $list_node_current_rel='CURRENT'.$REL;
        $list_node_next_rel='NEXT'.$REL;
        
        if ($this->is_leaf_node($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_key, $list_node_value, $list_node_current_rel)) {
			$cypher  = "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }})-[:" . $list_node_current_rel . "|" . $list_node_next_rel . "*0..]->(m:" . $list_node_label . " { " . $list_node_key . ": { list_node_value }}) ";
			$cypher .= "WITH m ";
			$cypher .= "MATCH (m)-[r]-() ";
			$cypher .= "DELETE m, r";
			return $cypher;
        }

        if ($this->is_current_node($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_key, $list_node_value, $list_node_current_rel)) {
			$cypher  = "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }})-[lp:" . $list_node_current_rel . "]->(del:" . $list_node_label . " { " . $list_node_key . ": { " . $list_node_value . " }})-[np:". $list_node_next_rel ."]->(nextNode) ";
			$cypher .= "CREATE UNIQUE (n)-[:" . $list_node_current_rel . "]->(nextNode) ";
			$cypher .= "DELETE lp, del, np";
			return $cypher;
        }
        
		$cypher  = "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }})-[:".$list_node_current_rel."|" . $list_node_next_rel . "*0..]->(before), ";
    	$cypher .= "(before)-[delBefore]->(del:" . $list_node_label . " { " . $list_node_key . ": { " . $list_node_value . " }})-[delAfter]->(after) ";
		$cypher .= "CREATE UNIQUE (before)-[:" . $list_node_next_rel . "]->(after) ";
		$cypher .= "DELETE del, delBefore, delAfter";
		return $cypher;
    }

    /**
     * Returns true if Content is the final, and oldest, Content item in the list
     * @return boolean True if Content is last, false otherwise
     */
    public  function is_leaf_node($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_key, $list_node_value, $list_node_current_rel)
    {
		$cypher .= "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }})-[:" . $list_node_current_rel . "|" . $list_node_next_rel . "*0..]->(m:" . $list_node_label . " { " . $list_node_key . ": { list_node_value }}) ";
		$cypher .= "WHERE NOT (m)-[:" . $list_node_next_rel . "]->() ";
		$cypher .= "RETURN m ";

        $result = $this->CI->neo->execute_query($queryString,array(
                'list_node_value' => $list_node_value,
                'parent_node_value' => $parent_node_value,
            ));
        return count($result) !== 0;
    }
    /**
     * Returns true if Content is the most recent, or current, Content item
     * @return boolean True if Content is most recent, false otherwise
     */
	public function is_current_node($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_key, $list_node_value, $list_node_current_rel)
    {
		$cypher = "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }})-[:" . $list_node_current_rel . "]->(m:" . $list_node_label . " { " . $list_node_key . ": { list_node_value }}) RETURN m ";

        $result = $this->CI->neo->execute_query($cypher, array(
                'parent_node_value' => $parent_node_value,
                'list_node_value' => $list_node_value,
            ));

        return count($result) !== 0;
    }

	public function get_content($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $skip=0, $limit=5)
    {

    	$list_node_next_rel = 'NEXT' . strtoupper($list_node_label);
    	$list_node_current_rel = 'CURRENT' . strtoupper($list_node_label);

		$this->cypher =  "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }}) ";
		$this->cypher .= "WITH n ";
		$this->cypher .= "MATCH (m:" . $list_node_label . ")-[:" . $list_node_next_rel . "*0..]-(l)-[:" . $list_node_current_rel . "]-(n) ";
		$this->cypher .= "OPTIONAL MATCH(u:User) ";
		$this->cypher .= "WHERE ID(u)=m.userId ";
		$this->cypher .= "RETURN m, ORDER BY m.timestamp SKIP {skip} LIMIT {limit} ";

        $result = $this->CI->neo->execute_query($this->cypher, array(
                'skip' => intval($skip),
                'limit' => intval($limit),
                'parent_node_value' => $parent_node_value,
            ));
        return $result;
    }

	public function get_content_count($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_next_rel, $list_node_current_rel)
    {
		$this->cypher  = "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }})";
		$this->cypher .= "WITH n";
		$this->cypher .= "MATCH (m:" . $list_node_label . ")-[:" . $list_node_next_rel . "*0..]-(l)-[:" . $list_node_current_rel . "]-(n)";
		$this->cypher .= "RETURN COUNT(m) as total";

        $result = $this->CI->neo->execute_query($this->cypher, array(
                'parent_node_value' => $parent_node_value,
            ));
        return $result;
    }

    /**
     * Gets content by contentId
     * @return Content[]
     */
    public function get_content_by_id($parent_node_label, $parent_node_key, $parent_node_value, $list_node_label, $list_node_key, $list_node_value, $list_node_next_rel, $list_node_current_rel)
    {
    	$this->cypher =  "MATCH (n:" . $parent_node_label . " { " . $parent_node_key . ": { parent_node_value }}) ";
		$this->cypher .= "WITH n ";
		$this->cypher .= "MATCH (m:" . $list_node_label . " { " . $list_node_key . ": { list_node_value }})-[:" . $list_node_next_rel . "*0..]-(l)-[:" . $list_node_current_rel . "]-(n) ";
		$this->cypher .= "RETURN m";
        
        $result = $this->CI->neo->execute_query($this->cypher, array(
                'list_node_value' => $list_node_value,
                'parent_node_value' => $parent_node_value,
            ));
        return $result;
    }
}