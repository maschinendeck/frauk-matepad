<?php
	class UserData {
		public $id;
		public $name;
		public $avatar;
		public $balance;

		public function signin() {
			setcookie(COOKIE_USER, $this->id, time() + 300); // Expire in 5Minutes
		}

		public function signout() {
			setcookie(COOKIE_USER, ""); // Never Expire
		}

	}

	class ItemData {
		public $id;
		public $name;
		public $costs;
		public $image;
	}

	class Storage {
		private $userList = array();
		private $itemList = array();

		// ID generator
		private function makeNewRandomID() {
			return sha1(random_bytes(32));
		}

		// Item Functions
		public function createItem($item) {
			$item->id = $this->makeNewRandomID();
			array_push($this->itemList, $item);
		}

		public function getAllItems() {
			return $this->itemList;
		}

		public function getItemByID($iid) {
			$items = $this->getAllItems();
			foreach ($items as $item) {
				if ($item->id == $iid) {
					return $item;
				}
			}
			return null;
		}

		public function removeItem($item) {
			foreach ($this->itemList as $key => $value) {
				if ($value->id == $item->id) {
					unset($key);
				}
			}
		}

		// User Functions
		public function createUser($user) {
			$user->id = $this->makeNewRandomID();
			array_push($this->userList, $user);
		}

		public function getAllUser() {
			return $this->userList;
		}

		public function getUserByID($uid) {
			$users = $this->getAlluser();
			foreach ($users as $user) {
				if ($user->id == $uid) {
					return $user;
				}
			}
			return null;
		}

		public function fetchUserByID($id) {
			foreach ($this->userList as $usr) {
				if ($usr->id == $id) {
					return $usr;
				}
			}
			return null;
		}

		public function removeUser($user) {
			foreach ($this->userList as $key => $value) {
				if ($value->id == $item->id) {
					unset($key);
				}
			}
		}

		// Serialization
		public function writeToDisk() {
			file_put_contents("user.json", json_encode($this->userList, JSON_PRETTY_PRINT));
			file_put_contents("item.json", json_encode($this->itemList, JSON_PRETTY_PRINT));
		}

		public function readFromDisk() {
			$this->userList = json_decode(file_get_contents("user.json"));
			$this->itemList = json_decode(file_get_contents("item.json"));
		}
	}
?>
