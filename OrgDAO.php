<?php
require_once "common.php";

class OrgDao{
    public function getOrg($username)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "select * from organiser where organiser_username = :org_username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':org_username',$username,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        while ($row = $stmt->fetch()){
            $user=new User(
            $row['organiser_username'],
            $row['organiser_name'],
            $row['organiser_hpnum'],
            $row['organiser_email'],
            $row['organiser_pocname'],
            $row['organiser_pocnum'],
            $row['organiser_password'],
            $row['organiser_website'],
            $row['organiser_description'],
            $row['organiser_photo']
        );
        }
        $stmt = null;
        $conn = null;
        return $user;
    }
    public function checkUserAndPassword($username,$password)
    {
        if($this->getOrg($username)!=null)
        {
            $user = $this->getOrg($username);
        if($user->getPass()== $password)
        {
            return true;
        }
        }
        
        return false;
    }
    public function registerOrg($org)
    {
        $sql = 'insert into organiser values(
        :organiser_username,
        :organiser_name,
        :organiser_hpnum,
        :organiser_email,
        :organiser_pocname,
        :organiser_pocnum,
        :organiser_password,
        :organiser_website,
        :organiser_description,
        :organiser_photo
        );';
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();
        $stmt = $conn->prepare($sql);
        $username = $org->getUsername();
        $name = $org->getOrg_name();
        $email = $org->getEmail();
        $phone = $org->getPhone_num();
        $poc_name = $org->getPoc_name();
        $poc_num = $org->getPoc_num();
        $password = $org->getOrg_pass();
        $website = $org->getUsername();
        $description = $org->getDescription();
        $photo = $org->getPhoto();
        $stmt->bindParam(':organiser_username',$username,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_name',$name,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_hpnum',$phone,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_pocname',$poc_name,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_pocnum',$poc_num,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_password',$password,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_website',$website,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_description',$description,PDO::PARAM_STR);
        $stmt->bindParam(':organiser_photo',$photo,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $status = $stmt->execute();
        return $status;
    }
}
?>