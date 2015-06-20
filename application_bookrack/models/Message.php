<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message extends CI_Model
{
	public $senderId;
	public $receiverId;
	public $messageId;
	public $nodeId;
	public $text;
    public $u1_name;
    public $u2_name;
    public $userimage;
	public $date_time;
	public $node;
	public $updated;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('neo');
	}

	public function setMessage($senderEmail, $receiverEmail)
	{
		$msg = new Message();
		$msg->senderId = self::getIdByEmail($senderEmail);
		$msg->receiverId = self::getIdByEmail($receiverEmail);
		$msg->message = $this->input->post('message');
		self::add($msg, $senderEmail, $receiverEmail);
	}

	public static function add(Message $msg, $e1, $e2)
	{
		$queryString = <<<CYPHER
MATCH (u1 { email: {e1}}),(u2 { email: {e2}})
OPTIONAL MATCH (u1)-[r1:CURRENTMESSAGE]->(currentmessage)<-[r2:CURRENTMESSAGE]-(u2)
DELETE r1,r2
CREATE UNIQUE (u1)-[:CURRENTMESSAGE]->(p:Message { u1:{user_one_id}, u2:{user_two_id}, message:{message}, date_time:{timestamp}, messageId:{messageId} })<-[:CURRENTMESSAGE]-(u2)
WITH p, collect(currentmessage) as currentmessages
FOREACH (x IN currentmessages | CREATE p-[:NEXTMESSAGE]->x)
RETURN p
CYPHER;
		$CI = get_instance();
		$result = $CI->neo->execute_query($queryString, array(
				'e1'=>$e1,
				'e2'=>$e2,
				'user_one_id'=>$msg->senderId,
				'user_two_id'=>$msg->receiverId,
				'message'=>$msg->message,
				'timestamp'=>time(),
				'messageId'=>uniqid()
			));
		return self::returnMappedContent($result);
	}

	public static function edit(Message $msg)
    {
        $updatedAt = time();

        $node = $msg->node;
        $node->setProperty('message', $status->message);
        $node->setProperty('u1', $msg->senderId);
        $node->setProperty('u2', $msg->receiverId);
        $node->setProperty('updated', $updatedAt);
        $node->save();

        $msg->updated = $updatedAt;

        return $msg;
    }

    public static function delete($email, $messageId)
    {
        $queryString = self::getDeleteQueryString($email, $messageId);
        $params = array(
            'email' => $email,
            'messageId' => $messageId,
        );

        $this->neo->execute_query($queryString,$params);
    }

    public static function isCurrentPost($email, $messageId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTMESSAGE]->(c:Message { messageId: { messageId }}) RETURN c
CYPHER;
		$result = $this->neo->execute_query($queryString,array(
				'email' => $email,
                'messageId' => $statusId,
			));

        return count($result) !== 0;
    }

    public static function isLeafPost($email, $messageId)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTMESSAGE|NEXTMESSAGE*0..]->(c:Message { messageId: { messageId }})
WHERE NOT (c)-[:NEXTMESSAGE]->()
RETURN c
CYPHER;
        $result = $this->neo->execute_query($queryString,array(
        		'email' => $email,
                'messageId' => $messageId,
        	));
        return count($result) !== 0;
    }

    protected static function getDeleteQueryString($email, $messageId)
    {
        if (self::isLeafPost($email, $messageId)) {
            return <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTMESSAGE|NEXTMESSAGE*0..]->(c:Message { messageId: { messageId }})
WITH c
MATCH (c)-[r]-()
DELETE c, r
CYPHER;
        }

        if (self::isCurrentPost($email, $messageId)) {
            return <<<CYPHER
MATCH (u:User { email: { email }})-[lp:CURRENTMESSAGE]->(del:Message { messageId: { messageId }})-[np:NEXTMESSAGE]->(nextMessage)
CREATE UNIQUE (u)-[:CURRENTMESSAGE]->(nextMessage)
DELETE lp, del, np
CYPHER;
        }

        return <<<CYPHER
MATCH (u:User { email: { email }})-[:CURRENTMESSAGE|NEXTMESSAGE*0..]->(before),
    (before)-[delBefore]->(del:Message { messageId: { messageId }})-[delAfter]->(after)
CREATE UNIQUE (before)-[:NEXTMESSAGE]->(after)
DELETE del, delBefore, delAfter
CYPHER;
	}

	public static function getMessageById($email, $messageId)
    {
        $queryString = <<<CYPHER
MATCH (usr:User { email: { u }})
WITH u
MATCH (p:Message { messageId: { messageId }})-[:NEXTMESSAGE*0..]-(l)-[:CURRENTMESSAGE]-(u)
RETURN p, u.first_name+' '+u.last_name AS username, u = usr AS owner
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString,array(
        		'u' => $email,
                'messageId' => $messageId,
        	));
        return self::returnMappedContent($result);
    }

    public static function getMessageCount($email)
    {
$queryString = <<<CYPHER
MATCH (u:User { email: { u }})-[]-(lp)-[]-(f:User { email: {u2} })
WITH DISTINCT u
MATCH u-[:CURRENTMESSAGE]-lp-[:NEXTMESSAGE*0..]-p
RETURN COUNT(p) as total
CYPHER;
		$CI = get_instance();
		return $result = $CI->neo->execute_query($queryString,array(
                'u' => $email,
                'u2' => $email,
            ));
    }

    public static function getContent($e1, $e2, $skip, $limit)
    {
        $queryString = <<<CYPHER
MATCH (u:User { email: { u1 }})-[]-(lp)-[]-(f:User { email: {u2} })
WITH DISTINCT u,f
MATCH u-[:CURRENTMESSAGE]-lp-[:NEXTMESSAGE*0..]-p
WHERE (lp.u1=ID(u) AND lp.u2=ID(f)) OR (lp.u2=ID(u) AND lp.u1=ID(f))
RETURN p, u.first_name+ ' ' + u.last_name as u1_name, f.first_name+ ' ' + f.last_name as u2_name, ID(u) as u1_id, f.profile_image as userimage
ORDER BY p.timestamp desc SKIP {skip} LIMIT {limit}
CYPHER;
        $CI = get_instance();
        $result = $CI->neo->execute_query($queryString,array(
        		'u1' => $e1,
        		'u2' => $e2,
                'skip' => intval($skip),
                'limit'=>intval($limit),
        	));
        return self::returnMappedContent($result);
    }

    public static function getAll($email)
    {
    	$queryString = <<<CYPHER
match(u1:User {email: {email} })-[:CURRENTMESSAGE]->(m:Message)<-[:CURRENTMESSAGE]-(u2:User)
RETURN u2.first_name + ' ' + u2.last_name as username, u2.email as email, m.message
CYPHER;
		$CI = get_instance();
		return $result = $CI->neo->execute_query($queryString,array(
        		'email' => $email
        	));
		
    }

    protected static function returnMappedContent(Everyman\Neo4j\Query\ResultSet $results)
    {
        $mappedContentArray = array();
        foreach ($results as $row) {
            $mappedContentArray[] = self::createFromNode(
                $row['p'],
                $row['u1_name'],
                $row['u2_name'],
                $row['u1_id'],
                $row['userimage']          
            );
        }

        return $mappedContentArray;
    }
	protected static function createFromNode(Everyman\Neo4j\Node $node, $u1_name = null, $u2_name = null, $u1_id = null, $userimage = null)
    {
        $msg = new Message();
        $msg->node = $node;
        $msg->nodeId = $node->getId();
        $msg->messageId = $node->getProperty('messageId');
        $msg->text = $node->getProperty('message');
        $msg->u1_name = $u1_name;
        $msg->u2_name = $u2_name;
        $msg->userimage = $userimage;
        $msg->date_time = gmdate("F j, Y g:i a", $node->getProperty('date_time'));
        return $msg;
    }
    protected static function getIdByEmail($email)
	{
		$cypher = "MATCH (n:User {email:{email}}) RETURN ID(n) as id LIMIT 1";
		$CI = get_instance();
		$result = $CI->neo->execute_query($cypher,array('email'=>$email));
		return $result[0]['id'];
	}
}
