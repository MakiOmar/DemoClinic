<?php
class PdrController {

	private $pdo;

	public function __construct( $pdo ) {
		$this->pdo = $pdo;
	}

    public function getRel( $doctor_id, $patient_id ){
        try {
			$stmt = $this->pdo->prepare( 'SELECT * FROM patient_doctor_rel WHERE doctor_id = :doctor_id AND patient_id = :patient_id' );
			$stmt->execute( array( 'doctor_id' => $doctor_id, 'patient_id' => $patient_id ) );
			return $stmt->fetch( PDO::FETCH_ASSOC );
		} catch ( PDOException $e ) {
			return false;
		}
    }
    public function updateRel( $doctor_id, $patient_id, $stage, $diagnose, $details, $prescription ){
        try {
			$stmt = $this->pdo->prepare( 'UPDATE patient_doctor_rel SET stage = :stage, details = :details, diagnose = :diagnose, prescription = :prescription WHERE doctor_id = :doctor_id AND patient_id = :patient_id' );
			$exc = $stmt->execute(
				array(
					'stage'    => $stage,
                    'details'       => $details,
					'diagnose'     => $diagnose,
					'prescription'       => $prescription,
                    'doctor_id' => $doctor_id,
					'patient_id'     => $patient_id,
				)
			);
            
			return true;
		} catch ( PDOException $e ) {
            
            var_dump($e->getMessage());
            die;
			return false;
		}
    }

    public function insertRel( $doctor_id, $patient_id, $stage, $diagnose, $details, $prescription ){
        try {
			$stmt = $this->pdo->prepare( 'INSERT INTO patient_doctor_rel (doctor_id, patient_id, stage, diagnose, details, prescription) VALUES (:doctor_id, :patient_id, :stage, :diagnose, :details, :prescription)' );
			$stmt->execute(
				array(
					'doctor_id' => $doctor_id,
					'patient_id'     => $patient_id,
					'stage'    => $stage,
					'diagnose'     => $diagnose,
					'details'       => $details,
					'prescription'       => $prescription,
				)
			);
			return true;
		} catch ( PDOException $e ) {
			return false;
		}
    }
}
