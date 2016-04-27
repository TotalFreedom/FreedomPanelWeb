<?php
class Users extends Db {

  public function __construct() {

  }

  public function user_exists($username) {
    Db::bind("username", $username);
    $user_info = Db::single("SELECT id FROM users WHERE username = :username;");
    if ($user_info != false) {
      return true;
    } else {
      return false;
    }
  }

  public function create_user($username, $password) {
    Db::bind("username", $username);
    Db:bind("password", $password);
    $response = Db::query("INSERT INTO users (username, password) VALUES(:username, :password)");
    if ($response) {
      return true;
    } else {
      return false;
    }
  }

  public function delete_user($username) {
    Db::bind("username", $username);
    $response = Db::query("DELETE FROM users WHERE username=:username");
    if ($reponse) {
      return true;
    } else {
      return false;
    }

  }

  public function hash_password($password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 20]);
    return $password_hash;
  }

  public function check_password($username, $password) {
    Db::bind("username", $username);
    $password_hash = Db::single("SELECT password FROM users WHERE username = :username;");
    if ($password_hash != false) {
      if (password_verify($password, $password_hash)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function update_password($username, $password) {
    Db::bind("username", $username);
    Db::bind("password", $password);
    $response = Db::query("UPDATE users SET password=:password WHERE username=:username");
    if ($response != false) {
      return true;
    } else {
      return false;
    }

  }

  public function get_user_info($username) {
    Db::bind("username", $username);
    $user_info = Db::row("SELECT * FROM users WHERE username = :username");
    if ($user_info) {
      return $user_info;
    } else {
      return false;
    }
  }


  public function update_role($username, $new_role) {
    Db::bind("username", $username);
    Db::bind("role", $new_role);
    $response = Db::query("UPDATE users SET role=:role WHERE username=:username");

    if ($response != false) {
      return true;
    } else {
      return false;
    }

  }

  public function create_login_token($username, $valid_for = 5184000) {
    $token = hash('sha512', uniqid(rand(), true));
    Db::bind("username", $username);
    Db::bind("token", $token);
    Db::bind("valid_until", time() + $valid_for);
    Db::bind("user_agent", $_SERVER['HTTP_USER_AGENT']);
    Db::bind("time_issued", time());

    $response = Db::query("INSERT INTO login_tokens (username, token, valid_until, user_agent, time_issued) VALUES (:username, :token, :valid_until, :user_agent, :time_issued)");

    if ($response != false) {
      return true;
    } else {
      return false;
    }

  }

  public function retrieve_login_token($token) {
    Db::bind("token", $token);
    $response = Db::row("SELECT * FROM login_tokens WHERE token=:token");

    if ($response != false) {
      if (time() > $response['valid_until']) {
        return false;
      }
      if ($response['disabled'] == "false") {
        return false;
      }

      return $response['username'];
    } else {
      return false;
    }

  }

  public function list_login_tokens($username) {
    if ($username == "*") {
      $response = Db::query("SELECT * FROM login_tokens");
    }

    if ($username != "*") {
      Db::bind("username", $username);
      $response = Db::query("SELECT * FROM login_tokens WHERE username=:username");
    }

    if ($response) {
      return $response;
    } else {
      return false;
    }
  }

  public function invalidate_login_token($token) {
    Db::bind("token", $token);
    $response = Db::query("UPDATE login_tokens SET disabled='false' WHERE token=:token");

    if ($response) {
      return true;
    } else {
      return false;
    }
  }

}

 ?>
