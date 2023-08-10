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

    public function fetch_data($filed, $table, $where = NULL, $value = NULL, $order = NULL, $all = NULL)
    {
        if($value == NULL) {
            
            if($all == NULL) {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table $order");
                $stmt->execute();
                return $stmt->fetch();

            }
            elseif($all == "fetchAll") {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table $order");
                $stmt->execute();
                return $stmt->fetchAll();
            }
        } else{
            if($all == NULL) {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table WHERE $where = ? $order");
                $stmt->execute(array($value));
                return $stmt->fetch();

            }
            elseif($all == "fetchAll") {

                $stmt = $this->conn->prepare("SELECT $filed FROM $table WHERE $where = ? $order");
                $stmt->execute(array($value));
                return $stmt->fetchAll();

            }
        }
    }
}

class User extends Connection
{
    private $login_errors = array();

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
                    if ($result['group_id'] == 0) {
                        $this->login_errors[] = "<div class='alert alert-danger'>You are not Admin!</div>";
                        return $this->login_errors;
                    } else {
                        $_SESSION['admin'] = $username_without_space;
                        $_SESSION['admin_id'] = $result['user_id'];
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

    public function push_item($name, $description, $price, $country, $status, $category, $image)
    {
        $stmt = $this->conn->prepare(" INSERT INTO items(name, description, price, country, item_status, category, image, item_date)
                                        VALUES(?,?,?,?,?,?,?,CURRENT_DATE()) ");
        $stmt->execute(array($name, $description, $price, $country, $status, $category, $image));

        return $stmt->rowCount();
    }

    public function insert_item($name, $description, $price, $country, $status, $category, $photo)
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

    public function modify_item($name, $description, $price, $country, $status, $category, $image, $item_id)
    {
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

    public function update_item($name, $description, $price, $country, $status, $category, $photo, $item_id)
    {
        $result = $this->fetch_data("name", "items", "item_id", $item_id);
        
        if (!empty($result)) {
            $item_name = $result['name'];

            $trim_name = trim($name);
            $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);
            

            if (empty($filter_name)) {
                $this->item_errors[] = "Item name required";
            }

            if (strlen($filter_name) < 2 && !empty($filter_name)) {
                $this->item_errors[] = "Item name must be larger than 2 characters";
            }

            $result = $this->fetch_data("name", "items", "name", $filter_name);

            if(empty($this->item_errors) && (empty($result) || $item_name == $filter_name)) {

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

                if (empty($this->item_errors)) {

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
                
                            $result = $this->modify_item($filter_name, $filter_description, $filter_price, $filter_country, $status, $category, $photo_upload_to_db, $item_id);
                            if ($result > 0) {
                                $this->item_errors[] = "Item Update Successfully";
                                return $this->item_errors;
                            } else {
                                $this->item_errors[] = "Item Not Changed";
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
                if(empty($this->item_errors)) {
                    $this->item_errors[] = 'This Item [ ' . $filter_name . ' ] Already Exist';
                    return $this->item_errors;
                }else {
                    return $this->item_errors;
                }
            }
        }
    }
    }

    public function approve_item($item_id)
    {
        $result = $this->fetch_data("name", "items", "item_id", $item_id);

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
        $result = $this->fetch_data("name", "items", "item_id", $item_id);

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


class Category extends Connection
{
    private $category_errors = array();

    public function push_category($name, $description, $ordering, $visibility, $commenting, $ads)
    {
        $stmt = $this->conn->prepare(" INSERT INTO categories(name, description, ordaring, visibility, allow_comment, allow_ads)
                                        VALUES(?,?,?,?,?,?)");
        $stmt->execute(array($name, $description, $ordering, $visibility, $commenting, $ads));

        return $stmt->rowCount();
    }

    public function insert_category($name, $description, $ordering, $visibility, $commenting, $ads)
    {
        $trim_name = trim($name);
        $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);
        $filter_description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($filter_name)) {
            $this->category_errors[] = "Category name required";
        }

        if (strlen($filter_name) < 1 && !empty($filter_name)) {
            $this->category_errors[] = "Category name must be larger than 1 characters";
        }

        if (empty($filter_description)) {
            $this->category_errors[] = "Category description required";
        }

        if (strlen($filter_description) < 20 && !empty($filter_description)) {
            $this->category_errors[] = "Category description must be larger than 20 characters";
        }

        if (empty($this->category_errors)) {

            $result = $this->fetch_data("name", "categories", "name", $filter_name);

            if (empty($result)) {

                $result = $this->push_category($filter_name, $filter_description, $ordering, $visibility, $commenting, $ads);
                if ($result > 0) {
                    $this->category_errors[] = "Category Insert Successfully";
                } else {
                    $this->category_errors[] = "Category Not Inserted, Please Try Again";
                }
                return $this->category_errors;
            } else {
                $this->category_errors[] = "$filter_name already exist";
                return $this->category_errors;
                }
        } else {
            return $this->category_errors;
            }
    }

    public function modify_category($name, $description, $ordering, $visibility, $commenting, $ads, $cat_id)
    {
        $stmt = $this->conn->prepare(" UPDATE  categories SET
                                        name = :new_name,
                                        description = :new_description,
                                        ordaring = :new_ordering,
                                        visibility = :new_visibility,
                                        allow_comment = :new_allow_comment,
                                        allow_ads = :new_allow_ads
                                        WHERE id = :cat_id
                                        ");
         $stmt->execute(array(
            "new_name" => $name,
            "new_description" => $description,
            "new_ordering" => $ordering,
            "new_visibility" => $visibility,
            "new_allow_comment" => $commenting,
            "new_allow_ads" => $ads,
            "cat_id" => $cat_id
        ));

        return $stmt->rowCount();
    }

    public function update_category($name, $description, $ordering, $visibility, $commenting, $ads, $cat_id) {
        $result = $this->fetch_data("name", "categories", "id", $cat_id);
        
        if (!empty($result)) {
            $cat_name = $result['name'];

            $trim_name = trim($name);
            $filter_name = filter_var($trim_name, FILTER_SANITIZE_SPECIAL_CHARS);
            $filter_description = filter_var($description, FILTER_SANITIZE_SPECIAL_CHARS);
            

            if (empty($filter_name)) {
                $this->category_errors[] = "category name required";
            }

            if (strlen($filter_name) < 1 && !empty($filter_name)) {
                $this->category_errors[] = "category name must be larger than 1 characters";
            }

            if (empty($filter_description)) {
                $this->category_errors[] = "category description required";
            }

            if (strlen($filter_description) < 20 && !empty($filter_description)) {
                $this->category_errors[] = "category description must be larger than 20 characters";
            }


            if (empty($this->item_errors)) {
                $result = $this->fetch_data("name", "categories", "name", $filter_name);

                if(empty($result) || $cat_name == $filter_name) {

                    /// update_fun===================================
                    $result = $this->modify_category($filter_name, $filter_description, $ordering, $visibility, $commenting, $ads, $cat_id);
                    if ($result > 0) {
                        $this->category_errors[] = "Item Update Successfully";
                        return $this->category_errors;
                    } else {
                        $this->category_errors[] = "Item Not Changed";
                        return $this->category_errors;
                    }
                } else {

                    if(empty($this->category_errors)) {
                        $this->category_errors[] = 'This Item [ ' . $filter_name . ' ] Already Exist';
                        return $this->category_errors;
                    }else {
                        return $this->category_errors;
                    }
                }
            } else {
                return $this->category_errors;
            }
            
           
        }
    }

    public function delete_category($cat_id)
    {
        $result = $this->fetch_data("name", "categories", "id", $cat_id);

        if (!empty($result)) {
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute(array($cat_id));
            if ($stmt->rowCount() > 0) {
                return "$result[name] Deleted";
            } else {
                return "Error $result[name] Not Deleted";
            }

        }
    }
}
