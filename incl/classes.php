<?php


    class BaseObject{

        private $id;

        function __construct($id)
        {
            $this->id = $id;
        }

        public function getId()
        {
            return $this->id;
        }
    }

    class OwnableObject{

        private $id;
        private $owner;

        function __construct($link, $id, $objectId)
        {

            $this->id = $id;
            $this->owner = new User($link, $objectId);
        }

        public function getId()
        {
            return $this->id;
        }

        public function getObjectId()
        {
            return $this->owner->getId();
        }

        public function getObject()
        {
            return $this->object;
        }
    }

    //uncomment when the rest is working as intended
/*
    class ActionLog extends OwnableObject {

        private $objectIdentifier;
        private $action;
        private $modified;
        private $newValue;

        protected $object;

        function __construct($link, $id, $objectId)
        {
            parent::__construct($link, $id, $objectId);

            $sql    = "SELECT * FROM detailed_logs WHERE id = " . $id;
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0)
            {

                return false;
            }
            $row = mysqli_fetch_assoc($result);

            $this->objectIdentifier = $row['object_identifier'];
            $this->action           = $row['action'];
            $this->modified         = $row['modified'];
            $this->newValue         = $row['new_value'];
        }

        public static function MakeLog($link, $user, $object, $action, $modified = null, $newValue = null)
        {

            $stmt = $link->prepare("INSERT INTO detailed_logs ('owner_id', 'object_identifier', 'action', 'modified', 'new_value') VALUES (?,?,?,?,?)");
            $stmt->bind_param("issss", $userId, $_objectIdentifier, $_action, $_modified, $_newValue);

            //Set variables
            $userId             = $user->getId();
            $_objectIdentifier  = ShareObject::createIdentifier($object);
            $_action            = htmlentities($action, ENT_QUOTES);
            $_modified          = htmlentities($modified, ENT_QUOTES);
            $_newValue          = htmlentities($newValue, ENT_QUOTES);

            if (!$stmt->execute())
            {
                return false;
            }

            $createdId = $stmt->insert_id;

            $stmt->close();
        }
    } */

    class ActivityLogger
    {
        public static function UpdateActivity($link, $userId, $token, $name)
        {

            $stmt = $link->prepare("SELECT * FROM activity_tracker WHERE owner_id = ? AND activity_token = ?");
            $stmt->bind_param("ssis", $_userId, $_token);

            $_userId    = htmlentities($userId, ENT_QUOTES);
            $_token     = htmlentities($token, ENT_QUOTES);

            $stmt->execute();

            $_name  = htmlentities($name, ENT_QUOTES);
            if ($_name == "") {

                $_name = null;
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {

                $stmt->close();

                $stmt = $link->prepare("INSERT INTO activity_tracker ('owner_id', 'activity_token', 'unix_timestamp', 'alias') VALUES (?,?,?,?)");
                $stmt->bind_param("isss", $_userId, $_token, $time, $_name);

                $time = time();

                $stmt->execute();

                $stmt->close();
            } else {

                $stmt->close();

                $row    = $result->fetch_assoc();

                $stmt   = $link->prepare("UPDATE activity_tracker SET unix_timestamp=?, alias=?, WHERE owner_id = ? AND activity_token = ?");
                $stmt->bind_param("ssis", $time, $_name, $_userId, $_token);

                $time = time();

                $stmt->execute();

                $stmt->close();
            }
        } 

        public static function GetActivity($link, $userId)
        {

            $_userId    = htmlentities($userId, ENT_QUOTES);
            $time       = time() - 60;

            $sql        = "SELECT alias FROM activity_tracker WHERE owner_id = " . $_userId . " AND unix_timestamp > " . $time;
            $result     = mysqli_query($link, $sql);

            $allAliases = array();

            while($row = mysqli_fetch_assoc($result)) {

                $allAliases[] = $row;
            }

            return $allAliases;
        }
    } */

    //Adding the other classes
    //source: https://phpdelusions.net/pdo/pdo_wrapper#dependency_injection
 /*    class PDO extends OwnableObject
    {
        protected static $instance;
        protected $pdo;

        public function __construct($link, $id, $objectId)
        {
            parent::__construct($link, $id, $objectId);

            $opt = array(
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES      => false,
            );

            $dsn = 'mysql:host=' . HOST . ';dbname=' . NAME . ';charset=' . CHARSET;
            $this->pdo = new PDO($dsn, USER, PASSWORD, $opt);
        }

        public static function instance()
        {

            if(self::$instance === null) {

                self::$instance = new self;
            }

            return self::$instance;
        }

        public function __call($method, $args)
        {
            return call_user_func_array(array($this->pdo, $method), $args);
        }

        public function run ($sql, $args = [])
        {

            if (!args) {

                return $this->query($sql);
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        }
    } */



    class school extends OwnableObject {

        private $school_name;
        private $school_username;

        public function __construct($link, $id, $objectId)
        {
            parent::__construct($link, $id, $objectId);
            $sql    = "SELECT * FROM school WHERE class_id = " . $id;
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0) {

                return false;
            }
            $row = mysqli_fetch_assoc($result);

            $this->school_name      = $row['school_name'];
            $this->school_username  = $row['school_username'];
        }

        public static function createSchool($link, $school_name, $school_username) {

            //Prepare statement
            $stmt = $link->prepare("INSERT INTO school (school_name, school_username) VALUES (?,?,?)");
            $stmt->bindParam($school_name, $school_username);

            $schoolName     = $school_name;
            $schoolUsername = $school_username;

            if (!$stmt->execute()) {

                return false;
            }

            $school_id      = $stmt->insert_id;

            $stmt->close();
            $createdSchool  = new schoolClass($link, $school_id);
            return $createdSchool;
        }
    }

    class schoolClass extends OwnableObject
    {

        private $class_name;
        private $class_teacher;

        public function __construct($link, $id, $objectId)
        {
            parent::__construct($link, $id, $objectId);
            $sql = "SELECT * FROM school_class WHERE class_id = " . $id;
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0) {

                return false;
            }
            $row = mysqli_fetch_assoc($result);

            $this->class_name = $row['class_name'];
            $this->class_teacher = $row['class_teacher'];
        }

        public static function createClass($link, $class_name, $class_teacher)
        {

            //Prepare statement
            $stmt = $link->prepare("INSERT INTO school_class (class_name, class_teacher) VALUES (?,?,?)");
            $stmt->bindParam($class_name, $class_teacher);

            $className = $class_name;
            $classTeacher = $class_teacher;

            if (!$stmt->execute()) {

                return false;
            }

            $class_id = $stmt->insert_id;

            $stmt->close();
            $createdClass = new schoolClass($link, $class_id);
            return $createdClass;
        }
    }

class User extends OwnableObject implements JsonSerializable
{

    private $student_number;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $age;
    private $loginTokens;

    public function __construct($link, $id, $objectId)
    {
        parent::__construct($link, $id, $objectId);
        $stmt = $link->prepare("SELECT * FROM users");
        $stmt->execute();
        if ($stmt->fetchAll() == 0) {

            return false;
        }
        $row = $stmt->fetchAll();

        $this->student_number   = $row['student_number'];
        $this->first_name       = $row['first_name'];
        $this->last_name        = $row['last_name'];
        $this->age              = $row['age'];
        $this->email            = $row['email'];
        $this->password         = $row['password'];
        $this->level            = $row['level'];

        // $this->setLoginTokens($link);

        //always close it to avoid multiple instances
        $stmt->close();
    }

    public static function createUser($link, $_studentNumber, $_firstName, $_lastName, $_age, $_userMail, $_userPass, $_level)
    {

        $studentNumber  = $_studentNumber;
        $firstName      = $_firstName;
        $lastName       = $_lastName;
        $userPass       = $_userPass;
        $userMail       = $_userMail;
        $age            = $_age;
        $level          = $_level;

        $stmt = $link->prepare("INSERT INTO users (student_number, first_name, last_name, age, email, password, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam("ississi", $studentNumber, $firstName, $lastName, $age, $userMail, $userPass, $level);

        if (!$stmt->execute()) {

            return false;
        }

        $createdId = $stmt->insert_id;

        //close statement afterwards
        $stmt->close();
        $createdUser = new User($link, $createdId);
        return $createdUser;
    }

    //Find the user by email
    public static function findUserByName($link, $_email) {

        $email  = htmlentities(strtolower($_email), ENT_QUOTES);

        $stmt   = $link->prepare("SELECT user_id, email FROM users WHERE email = ?");
        $stmt->bindParam("s", $email);

        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {

            return false;
        }

        $row    = $result->fetch();

        $stmt->closeCursor();

        return new User($link, $row['user_id']);
    }


    //Add Login
    function LoginUser($link, $userPass)
    {
        $stmt = $link->prepare("SELECT password FROM users WHERE user_id = " . $this->getId());
        $stmt->execute();
        $row = $stmt->fetchAll();

        return password_verify($userPass, $row['password']);
    }

    //Token system
    function makeUserToken($link)
    {

        $token = LoginToken::generateToken();

        $tokenQuery = "UPDATE users SET lastlogin_token ='$token' WHERE id = " . $this->getId();
        $tokenResult = mysqli_query($link, $tokenQuery);

        $this->loginTokens[] = LoginToken::createLoginTokens($link, $this, $token);

        return $token;
    }

    /*
    function makeLoginLog($link, $ip, $country, $city)
    {
        $sql = "INSERT INTO login_logs ('ip', 'country', 'user_id', 'city', 'timestamp') VALUES ('$ip', '$country'," . $this->getId() . ", '$city', " . time() . ")";
        $result = mysqli_query($link, $sql);
    } */

    //Validating Token login
    function validateUserLogin($token)
    {

        $tokenValid = false;
        foreach ($this->loginTokens as $loginToken) {

            if ($loginToken->checkToken($token)) {
                $tokenValid = true;
            }
        }

        return $tokenValid;
    }

    private function setLoginTokens($link)
    {

        $sql    = "SELECT * FROM login_tokens WHERE owner_id = " . $this->getId();
        $result = mysqli_query($link, $sql);

        $this->loginTokens = array();
        while ($row = mysqli_fetch_assoc($result)) {

            $this->loginTokens[] = new LoginToken($link, $row['id']);
        }
    }

    //functions to delete users
    function deleteUser($link, $user)
    {

        $stmt = $link->prepare("DELETE FROM users WHERE id = " . $user->getId());
        $stmt->execute();

        if (!$stmt) {

            throw new Exception("Could not delete user id: " . $user->getId());
        }

        // enable when logging has been enabled
        //    ActionLog::MakeLog($link, $user, "delete");
    }

    function deleteSchool($link, $school)
    {

        $sql = "DELETE FROM schools WHERE id = " . $school->getId() . "AND id = " . $this->getId();
        if (!mysqli_query($link, $sql)) {

            throw new exception("Could not delete school id: " . $school->getId());
        }
    }

    function deleteSchoolClass($link, $schoolClass)
    {

        $sql = "DELETE FROM school_class WHERE id = " . $schoolClass->getId() . " AND id = " . $this->getId();
        if (!mysqli_query($link, $sql)) {

            throw new Exception("Could not delete class id: " . $schoolClass->getId());
        }
    }

    function deleteClassTeacher($link, $user) {

        $stmt = $link->prepare("DELETE FROM couple_teacher_classes WHERE user_id = " . $_SESSION['user_id']);
        $stmt->prepare();

        if (!$stmt) {

            throw new Exception("Could not delete user id: " . $_SESSION['user_id']);
        }

        $stmt->close();
    }

    function deleteClassStudent($link, $user) {

        $stmt = $link->prepare("DELETE FROM couple_students_classes WHERE user_id = " . $_SESSION['user_id']);
        $stmt->execute();

        if (!$stmt) {

            throw new Exception("Could not delete user id: " . $_SESSION['user_id']);
        }

        $stmt->close();
    }

    public static function getAllSchoolClasses($link)
    {

        $query  = "SELECT * FROM school_class WHERE 1 ORDER BY class_name DESC";
        $result = mysqli_query($link, $query);

        $allClasses = array();

        while ($row = mysqli_fetch_assoc($result)) {

            //get all Classes in an array
            $allClasses[] = new schoolClass($link, $row['class_id']);
        }
    }

    public static function getAllSchools($link)
    {

        $query  = "SELECT * FROM schools WHERE 1 ORDER BY school_name";
        $result = mysqli_query($link, $query);

        $allSchools = array();

        while ($row = mysqli_fetch_assoc($result)) {

            //get all Schools in an array
            $allSchools[] = new school($link, $row['school_id']);
        }
    }

    public function jsonSerialize()
    {
        return [
            'id'            => $this->getId(),
            'first_name'    => $this->getfirstName(),
            'last_name'     => $this->getlastName(),
            'email'         => $this->getEmail(),
            'age'           => $this->getAge(),
            'studentNumber' => $this->getstudentNumber(),
            'level'         => $this->getLevel(),
        ];
    }
}
