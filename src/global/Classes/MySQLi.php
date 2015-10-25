<?php
/**
* MySQLi Object - Need to make interface for this, and other db engines
* Also, need to make this prepared statements at some point.
* Written by Matt Kent (@Kent55) adapted for FreedomPanelWeb (@TotalFreedom) by Charles Gillham (@TheCJGCJG)
*/
class sqlInt {

	/**
     * Allows multiple database connections
     * probably not used very often, but we'll add it anyway
     */
	private $connections = array();

	/**
     * Tells the DB object which connection to use
     * setActiveConnection($id) allows us to change this
     */
	private $activeConnection = 0;

	/**
     * Queries which have been executed and then "saved for later"
     */
	private $queryCache = array();

	/**
     * Data which has been prepared and then "saved for later"
     */
	private $dataCache = array();

	/**
     * Record of the last query
     */
	private $lastQuery = null;

	public function __construct() {

	}

	public function newConnection($host, $user, $password, $database) {
		$this->connections[] = new mysqli($host, $user, $password, $database);
		$connection_id = count($this->connections) - 1;

		// Error handling, need to add system for this
		if ($this->connections[$connection_id]->errno) {
			trigger_error($this->connections[$connection_id]->error, E_USER_ERROR);
		}

		return $connection_id;
	}

	public function closeConnection() {
		$this->connections[$this->activeConnection]->close();
	}

	public function setActiveConnection(int $id) {
		$this->activeConnection = $id;
	}

	public function cacheQuery($query_str) {
		if (!$result = $this->connections[$this->activeConnection]->query($query_str)) {
			trigger_error('Error executing and caching query: ' . $this->connections[$this->activeConnection]->error, E_USER_ERROR);

			return -1;
		}
		else {
			$this->queryCache[] = $result;
            return count($this->queryCache) - 1;
		}
	}

	public function numRowsFromCache($cache_id) {
		return $this->queryCache[$cache_id]->num_rows;
	}

	public function resultsFromCache($cache_id) {
		return $this->queryCache[$cache_id]->fetch_array(MYSQLI_ASSOC);
	}

	public function cacheData($data) {
		$this->dataCache[] = $data;
        return count($this->dataCache) - 1;
	}

	public function dataFromCache($cache_id) {
		return $this->dataCache[$cache_id];
	}

	public function deleteRecords($table, $condition, $limit) {
		$limit = ($limit == '') ? '' : ' LIMIT ' . $limit;
        $delete = "DELETE FROM {$table} WHERE {$condition} {$limit}";
        $this->executeQuery($delete);
	}

	public function updateRecords($table, $changes, $condition) {
		$update = "UPDATE " . $table . " SET ";
		foreach ($changes AS $f => $v) {
            $update .= "`" . $f . "`='{$v}',";
        }
        $update = substr($update, 0, -1);
        if( $condition != '' ) {
            $update .= "WHERE " . $condition;
        }

        $this->executeQuery($update);

        return true;
	}

	public function insertRecords($table, $data) {
        // setup some variables for fields and values
        $fields  = '';
        $values = '';

        // populate them
        foreach ($data AS $f => $v) {
            $fields  .= "`$f`,";
            $values .= (is_numeric($v) AND (intval($v) == $v)) ? $v . ',' : "'$v',";
        }

        // remove our trailing ,
        $fields = substr($fields, 0, -1);
        // remove our trailing ,
        $values = substr($values, 0, -1);

        $insert = "INSERT INTO $table ({$fields}) VALUES ({$values})";
        $this->executeQuery($insert);
        return true;
    }

    public function executeQuery($query_str) {
        if (!$result = $this->connections[$this->activeConnection]->query($query_str)) {
            trigger_error('Error executing query: '.$this->connections[$this->activeConnection]->error, E_USER_ERROR);
        }
        else {
            $this->last = $result;
        }

    }

    /**
     * Get the rows from the most recently executed query, excluding cached queries
     * @return array
     */
    public function getRows() {
        return $this->last->fetch_all(MYSQLI_ASSOC);
    }

    public function affectedRows() {
        return $this->$this->connections[$this->activeConnection]->affected_rows;
    }

    /**
     * Sanitize data
     * @param String the data to be sanitized
     * @return String the sanitized data
     */
    public function sanitizeData($data) {
        return $this->connections[$this->activeConnection]->real_escape_string($data);
    }

    /**
     * Deconstruct the object
     * close all of the database connections
     */
    public function __deconstruct() {
        foreach ($this->connections AS $connection) {
            $connection->close();
        }
    }


		/**
		* End of MySQLI Driver
		*
		* Start of pre-defined queries. Queries are all performed by calling one of these functions as all data can easily be sanitized from here.
		*/


		/**
		* Check if a user exists in the database, returns either True or False.
		*/
		public function query_userExists($username) {
			$username = $this->sanitizeData($username);
			$result = $this->executeQuery("SELECT id FROM users WHERE username='" . $username . "';");

			if ($result) {
				return true;
			} else {
				return false;
			}
		}

		/**
		* Retrieves all userdata associated with whichever colimn the query is being requested for. For example
		* if column=username. This will then return all cells associated with this username, and shall possibly
		* In the future be adapted to return user permissions etc. also.
		* Returns either the results (in an associative array), or returns false if the specified data cannot
		* be found in the column
		*/

		public function query_getUserData($options) {
			/*
			Options array will contain the following keys
			=> column
			=> value
			*/

			$column = $this->sanitizeData($options['column']);
			$value = $this->sanitizeData($options['value']);

			$result = $this->executeQuery("SELECT * FROM users WHERE " . $column ."='" . $value . "';");
			if ($result) {
				return $this->getRows();
			} else {
				return false;
			}

		}

		/*
		* Inserts a user into the database when given their username and password in the options array.
		*/

		public function query_insertUser($options) {
			/*
			Options array will contain the following as keys, soon to be more with permissions etc
			=> username
			=> password
			*/

			$username = $this->sanitizeData($options['username']);
			$password = $this->sanitizeData($options['password']);

			if ($this->executeQuery("INSERT INTO users (username, password) VALUES ('" . $username . "', '" . $password . "')")) {
				return true;
			} else {
				return false;
			}
		}

		/*
		* Deletes a user from the database with the given username.
		* Returns either true or false on Success/Failiure of the query. No check is made as to
		* the status of the data in the table.
		*/

		public function query_deleteUser($options) {
			/*
			Options array will contain the following as keys
			=> username
			*/

			$user_id = $this->sanitizeData($options['user_id']);

			if ($this->executeQuery("DELETE FROM users WHERE id='" . $user_id ."'")) {
				return true;
			} else {
				return false;
			}
		}

		public function query_deleteUserRoles($options) {
			/*
			Options array will contain the following as keys
			=> user_id
			*/
			$user_id = $this->sanitizeData($options['user_id']);

			if ($this->executeQuery("DELETE FROM user_roles WHERE user_id='" . $user_id ."'")) {
				return true;
			} else {
				return false;
			}
		}
		/*
		* When a username is given, this query will change the password value associated with said
		* username. This function returns true or false on success or failiure of the query
		* No check is made as to the success or failiure of the process.
		*/

		public function query_changePassword($options) {
			/*
			Options array will contain the following as keys
			=> username
			=> password
			*/

			$username = $this->sanitizeData($options['username']);
			$password = $this->sanitizeData($options['password']);

			if ($this->executeQuery("UPDATE users SET password='" . $password . "' WHERE username='" . $username ."';")) {
				return true;
			}	else {
				return false;
			}
		}

		public function query_updateAPIkey($options) {
			/*
			Options array will contain the following as keys
			=> username
			=> password
			*/

			$username = $this->sanitizeData($options['username']);
			$api_key = $this->sanitizeData($options['api_key']);

			if ($this->executeQuery("UPDATE users SET api_key='" . $api_key . "' WHERE username='" . $username ."';")) {
				return true;
			}	else {
				return false;
			}
		}

		public function query_getAPIKey($options) {
			/*
			Options array will contain the following as keys
			=> username
			*/

			$username = $this->sanitizeData($options['username']);
			$this->executeQuery("SELECT api_key FROM users WHERE username='" . $username ."';");
			return $this->getRows();
		}

		/*
		* Queries the users table to find the user ID of a particular user
		* Returns either true or false as to whether or not an ID is found for said
		* username in the database.
		*/

		public function query_getUserID($options) {
			/*
			Options array will contain the following as keys
			=> username
			*/

			$username = $this->sanitizeData($options['username']);

			$this->executeQuery("SELECT id FROM users WHERE username='" . $username . "';");
			if (TRUE != TRUE) {
				return false;
			} else {
				return $this->getRows();
			}

		}

		/*
		* This will return the role id (role_id) for a particular user (Also from the users ID)
		* This query will return true or false based on whether or not a role_id is found.
		*/

		public function query_getRoleByID($options) {
			/*
			Options array will contain the following as keys
			=> id
			*/

			$id = $this->sanitizeData($options['id']);

			$this->executeQuery("SELECT role_id FROM user_roles WHERE user_id='" . $id . "';");
			if (TRUE != TRUE) {
				return false;
			} else {
				return $this->getRows();
			}

		}

		public function query_getRoleName($options) {
			/*
			Options array will contain the following as keys
			=> role_id (If this is * return ALL Roles)
			*/

			if ($options['role_id'] == '*') {
				$this->executeQuery("SELECT * FROM roles ORDER BY role_id DESC");
			} else {
				$role_id = $this->sanitizeData($options['role_id']);
				$this->executeQuery("SELECT * FROM roles WHERE role_id='" . $role_id . "';");
			}


			return $this->getRows();

		}

		public function query_getRoleID($options) {
			/*
			Options array will contain the following as keys
			=> role_name
			*/

				$role_name = $this->sanitizeData($options['role_name']);
				$this->executeQuery("SELECT role_id FROM roles WHERE role_name='" . $role_name . "';");


			return $this->getRows();

		}

		// Login Token Queries

		public function query_insertLoginToken($options) {
			/*
			Options will contain the following keys in an array
			'username' => (which username will this token allow a login for?)
			'validUntil' => (value will be in seconds)
			'userAgent' => (should include the user agent of the browser the client is using)
			'token' => The token to be inserted
			*/

			$username = $this->sanitizeData($options['username']);
			$validUntil = $this->sanitizeData($options['validUntil']);
			$userAgent = $this->sanitizeData($options['userAgent']);
			$token = $this->sanitizeData($options['token']);
			$time = $this->sanitizeData(time());

			$this->executeQuery("INSERT INTO login_tokens (username, token, date_issued, user_agent, valid_until, is_valid) VALUES ('" . $username . "', '" . $token . "', '" . $time . "', '" . $userAgent . "', '" . $validUntil . "', '1')");
		}

		public function query_retrieveLoginToken($options) {
			/*
			Options will contain the following keys in an array
			'username' => If this is not present, it will be retrieved
			'token' => Which token to recieve ('*' for all')
			*/

			if (!isset($options['username'])) {
				$token = $this->sanitizeData($options['token']);
				$this->executeQuery("SELECT * FROM login_tokens WHERE token='" . $token . "'");
				$result = $this->getRows();
				return $result;
			}

			$username = $this->sanitizeData($options['username']);

			if ($options['token'] == '*') {
				$this->executeQuery("SELECT * FROM login_tokens WHERE username='" . $username . "'");
				return;
			} else {
				$token = $this->sanitizeData($options['token']);
				$this->executeQuery("SELECT * FROM login_tokens WHERE username='" . $username . "' AND token='" . $token ."'");
				return;
			}
		}

		public function query_invalidateLoginToken($options) {
			/*
			Options will contain the following keys in an array
			'username' => Which username to retrieve tokens for
			'token' => Which token to recieve ('*' for all')
			*/

			$username = $this->sanitizeData($options['username']);
			if ($options['token'] == '*') {
				$this->executeQuery("UPDATE login_tokens SET is_valid = '0' WHERE username='" . $username . "'");
			} else {
				$token = $this->sanitizeData($options['token']);
				$this->executeQuery("UPDATE login_tokens SET is_valid = '0' WHERE username='" . $username . "' AND token='" . $token ."'");
			}
		}

		public function query_getNavbarList() {
			$this->executeQuery('SELECT * FROM navigation_options');
			return($this->getRows());
		}

		public function query_getPermissionsForRole($options) {
			/*
			Options will contain the following keys in an array
			'role_id' => The ID of the role to get permissions for
			*/

			$role_id = $this->sanitizeData($options['role_id']);
			$this->executeQuery("SELECT * FROM role_perms WHERE role_id<='" . $role_id ."'");
			return $this->getRows();
		}

		public function query_updateRole($options) {
			/*
			Options will contain the following keys in an array
			'username' => The ID of the role to get permissions for
			'role' => The ID of the role that is to be assigned
			*/

			$user_id = $this->sanitizeData($options['username']);
			$role_id = $this->sanitizeData($options['role']);

			$result = $this->executeQuery("UPDATE user_roles SET role_id = '" . $role_id . "' WHERE user_id = '" . $user_id . "'");
			return $result;
		}

		public function query_insertRole($options) {
			/*
			Options will contain the following keys in an array
			'username' => The ID of the role to get permissions for
			'role' => The ID of the role that is to be assigned
			*/

			$user_id = $this->sanitizeData($options['user_id']);
			$role_id = $this->sanitizeData($options['role_id']);

			$result = $this->executeQuery("INSERT INTO user_roles (user_id, role_id) VALUES ('" . $user_id . "', '" . $role_id . "')");
			return $result;
		}


		public function query_addToCache($options) {
			/*
			Options will contain the following keys in an array
			'name' =>
			'data' =>
			'validUntil' =>
			*/

			$name = $this->sanitizeData($options['name']);
			$data = $this->sanitizeData($options['data']);
			$validUntil = $this->sanitizeData($options['validUntil']);
			$lastUpdate = $this->sanitizeData(time());

			$this->executeQuery("INSERT INTO cache (name, last_update, valid_until, data) VALUES ('" . $name ."', '" . $lastUpdate ."', '" . $validUntil ."', '" . $data ."') ON DUPLICATE KEY UPDATE name = VALUES(name), last_update = VALUES(last_update), valid_until = VALUES(valid_until), data = VALUES(data)");

		}

		public function query_getCacheTimes($options) {
			/*
			options will contain the following in an array
			'name' =>
			*/

			$name = $this->sanitizeData($options['name']);

			$this->executeQuery("SELECT last_update, valid_until FROM cache WHERE name='" . $name . "'");
			return $this->getRows();

		}

		public function query_retrieveFromCache($options) {
			/*
			options will contain the following in an array
			'name' =>
			*/

			$name = $this->sanitizeData($options['name']);
			$this->executeQuery("SELECT data FROM cache WHERE name='" . $name ."'");
			return $this->getRows();

		}

		public function query_getMaps($options) {
			/*
			options will contain the following in an array
			'name' => (Value will either be * or a map name)
			*/

			if ($options['name'] == '*') {
				$this->executeQuery('SELECT id, name, filename FROM maps');
			} else {
				$name = $this->sanitizeData($options['name']);
				$this->executeQuery("SELECT id, name, filename FROM maps WHERE name='" . $name . "'");
			}
			$mapData = $this->getRows();
			return $mapData;

		}

		public function query_getMapImage($options) {
			/*
			options will contain the following in an array
			'name' => (Value will either be * or a map name)
			*/
			$name = $this->sanitizeData($options['name']);
			$this->executeQuery("SELECT image FROM maps WHERE name='" . $name . "'");

			return $this->getRows();
		}

		public function query_listUsers() {
			$this->executeQuery("SELECT id, username FROM users");
			return $this->getRows();
		}

		public function query_logError($options) {
			/*
			'error_id' => $id,
      'human_error' => $human_error,
      'time' => time(),
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'username' => $username,
      'additional_info' = $additionalInfo
			*/
			$error_id = $this->sanitizeData($options['error_id']);
			$human_error = $this->sanitizeData($options['human_error']);
			$time = $this->sanitizeData($options['time']);
			$additional_info = $this->sanitizeData($options['additional_info']);
			$ip_address = $this->sanitizeData($options['ip_address']);
			$username = $this->sanitizeData($options['username']);

			$this->executeQuery("INSERT INTO error_logging (error_time, error_id, error_human, additional_info, ip_address, username) VALUES ('" . $time . "', '" . $error_id . "', '" . $human_error . "', '" . $additional_info . "', '" .  $ip_address. "', '" . $username . "')");

			// Dont return any errors, this function should remain silent
			return;
		}

}
