<?php
function is_selected( $data, $value ) {
	if ( $data === $value ) {
		return ' selected';
	}
	return '';
}

function is_checked( $data, $value ) {
	if ( $data === $value ) {
		return ' checked';
	}
	return '';
}

function handle_uploads() {
    if ( ! empty( $_FILES['prescription'] ) && ! empty( $_FILES['prescription']['name'] ) ) {
        // Handle file upload
        $uploadDir = 'uploads/';
        if ( ! is_dir( $uploadDir ) ) {
            mkdir( $uploadDir, 0777, true );
        }
        $fileName   = uniqid() . '_' . basename( $_FILES['prescription']['name'] );
        $uploadFile = $uploadDir . $fileName;
        $uploaded   = move_uploaded_file( $_FILES['prescription']['tmp_name'], $uploadFile );
        return $uploaded ? $uploadFile : false ;
    }
    return '';
}