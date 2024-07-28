<?php
class UserController {

	private $pdo;

	public function __construct( $pdo ) {
		$this->pdo = $pdo;
	}

	public function createUser( $username, $name, $email, $password, $role, $phone = '', $address = '', $house_number = '' ) {
		try {
			$hashedPassword = password_hash( $password, PASSWORD_BCRYPT );
			$stmt           = $this->pdo->prepare( 'INSERT INTO users (username, name, email, password, role, phone, address, house_number) VALUES (:username, :name, :email, :password, :role, :phone, :address, :house_number)' );
			$stmt->execute(
				array(
					'username'     => $username,
					'name'         => $name,
					'email'        => $email,
					'password'     => $hashedPassword,
					'role'         => $role,
					'phone'        => $phone,
					'address'      => $address,
					'house_number' => $house_number,
				)
			);
			return true;
		} catch ( PDOException $e ) {
			return false;
		}
	}

	public function getUserByUsername( $username ) {
		try {
			$stmt = $this->pdo->prepare( 'SELECT * FROM users WHERE username = :username' );
			$stmt->execute( array( 'username' => $username ) );
			return $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			return false;
		}
	}

	public function getUserByUserId( $id ) {
		try {
			$stmt = $this->pdo->prepare( 'SELECT * FROM users WHERE ID = :id' );
			$stmt->execute( array( 'id' => $id ) );
			return $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			return false;
		}
	}

	public function updateUser( $id, $name, $email, $phone, $house_number, $address, $role = null ) {
		try {
			$stmt = $this->pdo->prepare( 'UPDATE users SET name = :name, email = :email, phone = :phone, house_number = :house_number, address = :address, role = :role WHERE ID = :id' );
			$stmt->execute(
				array(
					'name'     => $name,
					'email'    => $email,
					'phone'    => $phone,
					'house_number'    => $house_number,
					'address'    => $address,
					'role'     => $role,
					'id'       => $id,
				)
			);
			return true;
		} catch ( PDOException $e ) {
			return false;
		}
	}

	public function deleteUser( $id ) {
		try {
			$stmt = $this->pdo->prepare( 'DELETE FROM users WHERE ID = :id' );
			$stmt->execute( array( 'id' => $id ) );
			return true;
		} catch ( PDOException $e ) {
			return false;
		}
	}
}
