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
}

$co = new Item ();
$co->name = "mostafa";
echo $co->name;


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
            $this->registration_errors[] = "Full name is required";
        }

        if (strlen($filter_full_name) < 4 && !empty($filter_full_name)) {
            $this->registration_errors[] = "Full name must be larger than 4 characters";
        }

        if (empty($username_without_spaces)) {
            $this->registration_errors[] = "Username is required";
        }

        if (strlen($username_without_spaces) < 4 && !empty($username_without_spaces)) {
            $this->registration_errors[] = "Username must be larger than 4 characters";
        }

        if (empty($filter_email)) {
            $this->registration_errors[] = "Email is required";
        }

        if (filter_var($filter_email, FILTER_VALIDATE_EMAIL) == false && !empty($filter_email)) {
            $this->registration_errors[] = "Email not valid";
        }

        if (empty($password)) {
            $this->registration_errors[] = "Password is required";
        }

        if (strlen($password) < 4 && !empty($password)) {
            $this->registration_errors[] = "Password must be larger than 4 characters";
        }

        if ($password != $confirm_password && !empty($password) && strlen($password) >= 4) {
            $this->registration_errors[] = "Password not match!";
        }

        if (empty($this->registration_errors)) {

            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
            $stmt->execute(array($username_without_spaces, $filter_valid_email));
            $result = $stmt->fetchAll();

            if (empty($result)) {
                $stmt = $this->conn->prepare("INSERT INTO users(full_name, username, email, reg_time, pass) VALUES(?,?,?, NOW(), ?)");
                $stmt->execute(array($filter_full_name, $username_without_spaces, $filter_valid_email, $hash_password));
                if ($stmt->rowCount() > 0) {
                    header("location: login.php");
                    exit();
                } else {
                    $this->registration_errors[] = "Error, please try again!";
                    return $this->registration_errors;
                }
            } else {
                foreach ($result as $res) {
                    if ($res['email'] == $filter_valid_email) {
                        $this->registration_errors[] = "This Email Already Exist";
                    } elseif ($res['username'] == $username_without_spaces) {
                        $this->registration_errors[] = "This Username Already Exist";
                    }
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
            $this->login_errors[] = "Username is required";
        }

        if (strlen($username_without_space) < 4 && !empty($username_without_space)) {
            $this->login_errors[] = "Username must be larger than 4 characters";
        }

        if (empty($password)) {
            $this->login_errors[] = "Password is required";
        }

        if (strlen($password) < 4 && !empty($password)) {
            $this->login_errors[] = "Password must be larger than 4 characters";
        }

        if (empty($this->login_errors)) {

            $stmt = $this->conn->prepare("SELECT user_id, pass, group_id FROM users WHERE username = ?");
            $stmt->execute(array($username_without_space));
            $result = $stmt->fetch();

            if (empty($result)) {
                $this->login_errors[] = "Wrong Username Or Password!";
                return $this->login_errors;
            } else {
                if (!password_verify($password, $result['pass'])) {
                    $this->login_errors[] = "Password not true";
                    return $this->login_errors;
                } else {
                    if ($result['group_id'] == 0) {
                        $this->login_errors[] = "You are not Admin!";
                        return $this->login_errors;
                    } else {
                        $_SESSION['admin'] = $username_without_space;
                        $_SESSION['user_id'] = $result['user_id'];
                        header("location: dashboard.php");
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

    // private function filter_item($name, $description, $price, $country, $status, $category) {
    //     $trim_name = trim($name);
    //     $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);
    //     $filter_description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
    //     $filter_price = filter_var($price, FILTER_SANITIZE_SPECIAL_CHARS);
    //     $filter_country = filter_var($country, FILTER_SANITIZE_SPECIAL_CHARS);

    //     if(empty($filter_name)) {
    //         $this->item_errors[] = "Item name required";
    //     }

    //     if(strlen($filter_name) < 5 && !empty($filter_name)) {
    //         $this->item_errors[] = "Item name must be larger than 5 characters";
    //     }

    //     if(empty($filter_description)) {
    //         $this->item_errors[] = "Item description required";
    //     }

    //     if(strlen($filter_description) < 20 &&  !empty($filter_description)) {
    //         $this->item_errors[] = "Item description must be larger than 20 characters";
    //     }

    //     if(empty($filter_price)) {
    //         $this->item_errors[] = "Item price required";
    //     }

    //     if($filter_price <= 0 && !empty($filter_price)) {
    //         $this->item_errors[] = "Item price must be larger than zero dollar";
    //     }

    //     if(empty($filter_country)) {
    //         $this->item_errors[] = "Item country required";
    //     }

    //     if(empty($status)) {
    //         $this->item_errors[] = "Item status required";
    //     }

    //     if(empty($category)) {
    //         $this->item_errors[] = "Item category required";
    //     }
    //     // if(empty($this->item_errors)){
    //     //     $this->item_errors['name'] = "true";
    //     //     $this->item_errors['item_name'] = $filter_name;
    //     //     return $this->item_errors;
    //     // } else
    //      return $this->item_errors;
    // }

    public function get_item($select, $where = null, $value = null, $and = null, $all = null)
    {
        $new_and = $and != null ? "AND $and = $and" : "";
        $new_where = $where != null ? "WHERE $where = ? $new_and" : "";

        if ($all == "fetchAll") {
            $stmt = $this->conn->prepare("SELECT $select FROM items $new_where");
            $stmt->execute(array($value));
            return $stmt->fetchAll();
        } else {

            $stmt = $this->conn->prepare("SELECT $select FROM items $new_where LIMIT 1");
            $stmt->execute(array($value));
            return $stmt->fetch();
        }
    }

    public function push_item($name, $description, $price, $country, $status, $category)
    {
        $image = './upload/image/w39239.png';
        $stmt = $this->conn->prepare(" INSERT INTO items(name, description, price, country, item_status, category, image, item_date)
                                       VALUES(?,?,?,?,?,?,?,CURRENT_DATE()) ");
        $stmt->execute(array($name, $description, $price, $country, $status, $category, $image));

        return $stmt->rowCount();
    }

    public function insert_item($name, $description, $price, $country, $status, $category)
    {

        // $filter_data = $this->filter_item($name, $description, $price, $country, $status, $category);
        $trim_name = trim($name);
        $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);
        $filter_description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
        $filter_price = filter_var($price, FILTER_SANITIZE_SPECIAL_CHARS);
        $filter_country = filter_var($country, FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($filter_name)) {
            $this->item_errors[] = "Item name required";
        }

        if (strlen($filter_name) < 5 && !empty($filter_name)) {
            $this->item_errors[] = "Item name must be larger than 5 characters";
        }

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

        if (empty($item_errors)) {
            $result = $this->get_item("name", "name", $filter_name);

            if (empty($result)) {

                $result = $this->push_item($filter_name, $filter_description, $filter_price, $filter_country, $status, $category);
                if ($result > 0) {
                    $this->item_errors[] = "Item Insert Successfully";
                    return $this->item_errors;
                } else {
                    $this->item_errors[] = "Error item not added, please try again";
                    return $this->item_errors;
                }
            } else {
                $this->item_errors[] = "$filter_name already exist";
                return $this->item_errors;
            }
        } else {
            return $item_errors;
        }

    }

    public function modify_item($name, $description, $price, $country, $status, $category, $item_id)
    {
        $image = './upload/image/w39239.png';
        $stmt = $this->conn->prepare(" UPDATE  items SET
                                        name = :new_name,
                                        description = :new_description,
                                        price = :new_price,
                                        country = :new_country,
                                        item_status = :new_status,
                                        category = :new_category,
                                        image = :new_image
                                        WHERE item_id = :id
                                        ");
        $stmt->execute(array(
            "new_name" => $name,
            "new_description" => $description,
            "new_price" => $price,
            "new_country" => $country,
            "new_status" => $status,
            "new_category" => $category,
            "new_image" => $image,
            "id" => $item_id));

        return $stmt->rowCount();
    }

    public function update_item($name, $description, $price, $country, $status, $category, $item_id)
    {
        $result = $this->get_item("name", "item_id", $item_id);

        if (!empty($result)) {

            // $filter_data = $this->filter_item($name, $description, $price, $country, $status, $category);

            $trim_name = trim($name);
            $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);
            $filter_description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
            $filter_price = filter_var($price, FILTER_SANITIZE_SPECIAL_CHARS);
            $filter_country = filter_var($country, FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($filter_name)) {
                $this->item_errors[] = "Item name required";
            }

            if (strlen($filter_name) < 5 && !empty($filter_name)) {
                $this->item_errors[] = "Item name must be larger than 5 characters";
            }

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

            if (empty($this->item_errors)) {

                /// update_fun===================================
                $result = $this->modify_item($filter_name, $filter_description, $filter_price, $filter_country, $status, $category, $item_id);
                if ($result > 0) {
                    $this->item_errors[] = "Item Update Successfully";
                    return $this->item_errors;
                } else {
                    $this->item_errors[] = "Error item not added, please try again";
                    return $this->item_errors;
                }
            } else {
                return $this->item_errors;
            }

        }
        // else {
        //     $this->item_errors[] = "$name not exist";
        //     return $this->item_errors;
        // }
    }

    public function approve_item($item_id)
    {
        // get_item($select, $where = NULL, $value = NULL, $and = NULL, $all = NULL) ;
        $result = $this->get_item("name", "item_id", $item_id);

        if (!empty($result)) {
            $stmt = $this->conn->prepare("UPDATE items SET approve = 1 WHERE item_id = ?");
            $stmt->execute(array($item_id));
            if ($stmt->rowCount() > 0) {
                return "$result[name] Approved";
            } else {
                return "Error $result[name] Not Approved";
            }

        }
    }

    public function delete_item($item_id)
    {
        $result = $this->get_item("name", "item_id", $item_id);

        if (!empty($result)) {
            $stmt = $this->conn->prepare("DELETE FROM items WHERE item_id = ?");
            $stmt->execute(array($item_id));
            if ($stmt->rowCount() > 0) {
                return "$result[name] Deleted";
            } else {
                return "Error $result[name] Not Deleted";
            }

        }
    }
}

class Database extends Connection
{
    public function get_all($select, $table, $where = null, $value = null)
    {
        $where = $where != null ? "WHERE $where" : null;

        $stmt = $this->conn->prepare("SELECT $select FROM $table $where");
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    }
}
