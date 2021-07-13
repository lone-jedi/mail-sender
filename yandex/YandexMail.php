<?php

class YandexMail
{
    public const HOST = "{pop.yandex.com:995/pop3/ssl}INBOX";

    private $username;
    private $password;

    protected $connection;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;

        $this->connection = imap_open(YandexMail::HOST,  $this->username, $this->password);
        
        if(!is_resource($this->connection))
            throw new Exception(YandexMail::getErrorStackTrace()); 
    }

    public static function getErrorStackTrace() : string {
        ob_start();
        echo '<hr><b>Cannot connect to Yandex: </b><br>';
        echo '<pre>';
        print_r(imap_errors());
        echo '</pre><hr>';
        return ob_get_clean();
    }

    public function getAllEmailsByDuration(int $duration, array $ids, array $params) : array {
        $result = [];
        
        foreach($ids as $msgno) {
            $overview = imap_fetch_overview($this->connection, $msgno, 0);

            if(time() - $overview[0]->udate > 0 && time() - $overview[0]->udate < $duration) {
                $mail = $this->getEmail($msgno);
                
                foreach($params['allowed_emails'] as $email => $function) {
                    if($mail['from'] == $email) {
                        $result[$msgno] = $function($mail);
                    }
                }
                
            }
        }

        return $result;
    }

    public function getEmail(int $msgno) : array {
        $message = imap_body($this->connection, $msgno);
        
        $headers = imap_headerinfo($this->connection, $msgno);
        $structure = imap_fetchstructure($this->connection, $msgno);
        $overview = imap_fetch_overview($this->connection, $msgno, 0);

        // if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
            $part = $structure->parts[1];

            // $message = imap_fetchbody($this->connection, $msgno,2);

            if($part->encoding == 3) {
                $message = imap_base64($message);
            } else if($part->encoding == 1) {
                $message = imap_8bit($message);
            } else {
                $message = imap_qprint($message);
            }
        // }

        $from = imap_utf8($overview[0]->from);
        $when = imap_utf8($overview[0]->date);
        $subject = imap_utf8($overview[0]->subject);

        preg_match('/\d{9,18}/', $message, $phone);

        return [
            "date" => $when,
            "subject" => $subject,
            "personal" => $from,
            "from" => ($headers->from)[0]->mailbox . '@' . ($headers->from)[0]->host,
            "recent" => $headers->Recent,
            "body" => $message,
            "phone" => $phone[0],
        ];
    }

    /*
    public function getEmailByUid(int $uid) : array {
        $message = imap_body($this->connection, $uid, FT_UID);
        
        $headers = imap_headerinfo($this->connection, $uid);
        $structure = imap_fetchstructure($this->connection, $uid, FT_UID);
        $overview = imap_fetch_overview($this->connection, $uid, FT_UID);

        // if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
            $part = $structure->parts[1];

            // $message = imap_fetchbody($this->connection, $msgno,2);

            if($part->encoding == 3) {
                $message = imap_base64($message);
            } else if($part->encoding == 1) {
                $message = imap_8bit($message);
            } else {
                $message = imap_qprint($message);
            }
        // }

        $from = imap_utf8($overview[0]->from);
        $when = imap_utf8($overview[0]->date);
        $subject = imap_utf8($overview[0]->subject);

        preg_match('/\d{9,18}/', $message, $phone);

        return [
            "date" => $when,
            "subject" => $subject,
            "personal" => $from,
            "from" => ($headers->from)[0]->mailbox . '@' . ($headers->from)[0]->host,
            "recent" => $headers->Recent,
            "body" => $message,
            "phone" => $phone[0],
        ];
    }
    public function getAllEmails() {
        // $result = [];

        // $count = imap_num_msg($this->connection);

        // for($msgno = 1; $msgno <= $count; $msgno++) {    
        //         $result[$msgno] = $this->getEmail($msgno);
        // }

        // return $result;
        
        // 
        // $uids = imap_search($this->connection, 'ALL', SE_UID);
        return imap_search($this->connection, 'ALL', SE_UID);
        $result = [];
        
        foreach($uids as $msgno) {
            $result[] = $this->getEmailByUid($msgno);
        }

        return $result;
    }
    */
    
    public function getEmailsIdByToday() : array {
        return imap_search($this->connection, 'ON "' . date('j F Y') . '"');
    }
    
    public function closeConnection() {
        imap_close($this->connection);
    }
}