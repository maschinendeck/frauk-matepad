<?php
	class UserData {
		public $id;
		public $name;
		public $balance;
	}

	class ItemData {
		public $id;
		public $name;
		public $costs;
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
			file_put_contents("user.json", json_encode($this->userList));
			file_put_contents("item.json", json_encode($this->itemList));
		}

		public function readFromDisk() {
			$this->userList = json_decode(file_get_contents("user.json"));
			$this->itemList = json_decode(file_get_contents("item.json"));
		}
	}
?>
