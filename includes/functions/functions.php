<?php
class Connection
{
    private $dsn = "mysql:host=localhost;dbname=ecommerce";
    private $user = "root";
    private $pass = "";
    private $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    );
    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->user, $this->pass, $this->options);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Failed to connect " . $e->getMessage();
        }
    }

    public function __call($method, $params) {
        echo 'This Method [ ' . $method . ' ] Not Found Or Not Accessible';
        echo '<pre>';
        print_r($params);
        echo '</pre>';
    }

    public function __get($prop) {
        echo 'This Property [ ' . $prop . ' ] Not Found Or Not Accessible!<br>';
    }

    public function __set($prop, $val) {
        echo 'This Property [ ' . $prop . ' ] Not Found Or Not Accessible!<br>';
        echo 'And You Can\'t Assign This Value [ ' . $val . ' ] To It<br>';
    }

    public function fetch_data($filed, $table, $where = NULL, $value = NULL, $order = NULL, $limit = NULL, $all = NULL)
    {
        if($value == NULL) {
            
            if($all == NULL) {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table $order $limit");
                $stmt->execute();
                return $stmt->fetch();

            }
            elseif($all == "fetchAll") {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table $order $limit");
                $stmt->execute();
                return $stmt->fetchAll();
            }
        } else{
            if($all == NULL) {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table WHERE $where = ? $order $limit");
                $stmt->execute(array($value));
                return $stmt->fetch();

            }
            elseif($all == "fetchAll") {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table WHERE $where = ? $order $limit");
                $stmt->execute(array($value));
                return $stmt->fetchAll();

            }
        }
    }
}

class User extends Connection
{
    private $registration_errors = array();
    private $login_errors = array();

    public function register($full_name, $username, $email, $password, $confirm_password)
    {

        $filter_full_name = filter_var($full_name, FILTER_SANITIZE_SPECIAL_CHARS);
        $filter_username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
        $username_without_spaces = str_replace(" ", "", $filter_username);
        $filter_email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $filter_valid_email = filter_var($filter_email, FILTER_VALIDATE_EMAIL);

        if (empty($filter_full_name)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Full name is required</div>";
        }

        if (strlen($filter_full_name) < 4 && !empty($filter_full_name)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Full name must be larger than 4 characters</div>";
        }

        if (empty($username_without_spaces)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Username is required</div>";
        }

        if (strlen($username_without_spaces) < 4 && !empty($username_without_spaces)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Username must be larger than 4 characters</div>";
        }

        if (empty($filter_email)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Email is required</div>";
        }

        if (filter_var($filter_email, FILTER_VALIDATE_EMAIL) == false && !empty($filter_email)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Email not valid</div>";
        }

        if (empty($password)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Password is required</div>";
        }

        if (strlen($password) < 4 && !empty($password)) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Password must be larger than 4 characters</div>";
        }

        if ($password != $confirm_password && !empty($password) && strlen($password) >= 4) {
            $this->registration_errors[] = "<div class='alert alert-danger'>Password not match!</div>";
        }

        if (empty($this->registration_errors)) {

            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
            $stmt->execute(array($username_without_spaces, $filter_valid_email));
            $result = $stmt->fetch();
            // $result = $this->fetch_data("username, email", "users", "username", $username_without_spaces,
            //                             "OR", "email", $filter_valid_email);

            if (empty($result)) {
                $stmt = $this->conn->prepare("INSERT INTO users(full_name, username, email, pass, reg_time) VALUES(?,?,?,?,?)");
                $stmt->execute(array($filter_full_name, $username_without_spaces, $filter_valid_email, $hash_password, date("Y-m-d")));
                if ($stmt->rowCount() > 0) {
                    header("location: login.php");
                    exit();
                } else {
                    $this->registration_errors[] = "<div class='alert alert-danger'>Error, please try again!</div>";
                    return $this->registration_errors;
                }
            } else {
                    if ($result['username'] == $username_without_spaces) {
                        $this->registration_errors[] = "<div class='alert alert-danger'>This Username Already Exist</div>";
                    } 

                    if ($result['email'] == $filter_valid_email) {
                        $this->registration_errors[] = "<div class='alert alert-danger'>This Email Already Exist</div>";
                    }
                return $this->registration_errors;
            }
        } else {
            return $this->registration_errors;
        }

    }

    public function login($username, $password)
    {
        $filter_username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
        $username_without_space = str_replace(' ', '', $filter_username);

        if (empty($username_without_space)) {
            $this->login_errors[] = "<div class='alert alert-danger'>Username is required</div>";
        }

        if (strlen($username_without_space) < 4 && !empty($username_without_space)) {
            $this->login_errors[] = "<div class='alert alert-danger'>Username must be larger than 4 characters</div>";
        }

        if (empty($password)) {
            $this->login_errors[] = "<div class='alert alert-danger'>Password is required</div>";
        }

        if (strlen($password) < 4 && !empty($password)) {
            $this->login_errors[] = "<div class='alert alert-danger'>Password must be larger than 4 characters</div>";
        }

        if (empty($this->login_errors)) {

            $result = $this->fetch_data("user_id, pass, group_id", "users", "username", $username_without_space);

            if (empty($result)) {
                $this->login_errors[] = "<div class='alert alert-danger'>Wrong Username Or Password!</div>";
                return $this->login_errors;
            } else {
                if (!password_verify($password, $result['pass'])) {
                    $this->login_errors[] = "<div class='alert alert-danger'>Password not true</div>";
                    return $this->login_errors;
                } else {
                    if ($result['group_id'] == 1) {
                        $this->login_errors[] = "<div class='alert alert-danger'>You are Admin!</div>";
                        return $this->login_errors;
                    } else {
                        $_SESSION['user'] = $username_without_space;
                        $_SESSION['user_id'] = $result['user_id'];
                        header("location: index.php");
                        exit();
                    }
                }
            }
        } else {
            return $this->login_errors;
        }

    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("location: index.php");
        exit();
    }
}


class Item extends Connection
{
    private $item_errors = array();

    public function push_item($item_id, $user_id, $quantity)
    {
        $stmt = $this->conn->prepare(" INSERT INTO cart (item_id, user_id, quantity, cart_date)
                                        VALUES(?,?,?,?)");
        $stmt->execute(array($item_id, $user_id, $quantity, date("Y-m-d")));

        return $stmt->rowCount();
    }


    public function push_comment($item_id, $user_id, $comment)
    {
        $filter_comment = filter_var($comment, FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($filter_comment)) {

            $stmt = $this->conn->prepare(" INSERT INTO comments (comment, com_from_user, com_to_item, com_date)
            VALUES(?,?,?,?)");
            $stmt->execute(array($filter_comment, $user_id, $item_id, date("Y-m-d")));

            return "<div class='alert alert-success'>Comment Added successfully.</div>";

        } else {
            return '<div class="alert alert-danger" role="alert"><strong>Sorry!</strong> Comment Shouldn\'t Be Empty</div>';
        }
    }

    public function insert_comment($item_id, $description, $price, $country, $status, $category, $photo)
    {
        $trim_name = trim($name);
        $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($filter_name)) {
            $this->item_errors[] = "Item name required";
        }

        if (strlen($filter_name) < 2 && !empty($filter_name)) {
            $this->item_errors[] = "Item name must be larger than 2 characters";
        }
        if (empty($this->item_errors)) {

            $result = $this->fetch_data("name", "items", "name", $filter_name);

            if (empty($result)) {

                $filter_description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
                $filter_price = filter_var($price, FILTER_SANITIZE_SPECIAL_CHARS);
                $filter_country = filter_var($country, FILTER_SANITIZE_SPECIAL_CHARS);


                if (empty($filter_description)) {
                    $this->item_errors[] = "Item description required";
                }

                if (strlen($filter_description) < 20 && !empty($filter_description)) {
                    $this->item_errors[] = "Item description must be larger than 20 characters";
                }

                if (empty($filter_price)) {
                    $this->item_errors[] = "Item price required";
                }

                if ($filter_price <= 0 && !empty($filter_price)) {
                    $this->item_errors[] = "Item price must be larger than zero dollar";
                }

                if (empty($filter_country)) {
                    $this->item_errors[] = "Item country required";
                }

                if (empty($status)) {
                    $this->item_errors[] = "Item status required";
                }

                if (empty($category)) {
                    $this->item_errors[] = "Item category required";
                }

                if (empty($photo)) {
                    $this->item_errors[] = "Item Image required";
                }

                $types_array = array("jpg", "png", "gif");

                $name_as_array = explode(".", $photo['name']);
                
                $type = strtolower(end($name_as_array));
                
                if(!in_array($type, $types_array) && !empty($photo['name'])) {
                    $this->item_errors[] = "Type Photo Not Allow";
                }
                
                if (empty($this->item_errors)) {
                    $photo_location = $photo['tmp_name'];
                    
                    $time    = date("y-m-d H:i:s");
                    $random  = rand(1,1000);
                    $time    = str_replace("-","$random",$time);
                    $random  = rand(1,1000);
                    $time    = str_replace(" ","$random",$time);
                    $random  = rand(1,1000);
                    $time    = str_replace(":", "$random", $time);

                    $photo_upload = "/backend_project/from_github/e-Commerce/admin/uploads/images/" . $time . ".$type";
                    $photo_upload_to_db = "./uploads/images/" . $time . ".$type";

                    if(move_uploaded_file($photo_location, $_SERVER['DOCUMENT_ROOT'] . $photo_upload)) {
            
                        $result = $this->push_item($filter_name, $filter_description, $filter_price, ucfirst($filter_country), $status, ucfirst($category), $photo_upload_to_db);
                        if ($result > 0) {
                            $this->item_errors[] = "$filter_name Insert Successfully";
                            return $this->item_errors;
                        } else {
                            $this->item_errors[] = "$filter_name Not Inserted, Please Try Again";
                            return $this->item_errors;
                        }
                
                    } else {
                        $this->item_errors[] = "Image Not Uploaded, Please Try Again";
                        return $this->item_errors;
                    }

                } else {
                    return $this->item_errors;
                    } 
            } else {
                $this->item_errors[] = "$filter_name already exist";
                return $this->item_errors;
                }
        } else {
            return $this->item_errors;
            }
    }
    public function delete_item($item_id, $user_id)
    {
            $stmt = $this->conn->prepare("DELETE FROM cart WHERE item_id = ? AND user_id = ?");
            $stmt->execute(array($item_id, $user_id));
            if ($stmt->rowCount() > 0) {
                return "Item Deleted";
            } else {
                return "Sorry Please Try Again!";
            }
    }
}


