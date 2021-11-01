<?php 

class Constants{
    static $DB_SERVER = 'localhost';
    static $USERNAME = 'root';
    static $PASSWORD = '';
    static $DB_NAME = 'restapi';
}

$notes = new Notes();
$notes->handleRequest();

class Notes{


    public function connect()
    {
        $conn= new mysqli(Constants::$DB_SERVER, Constants::$USERNAME, Constants::$PASSWORD, Constants::$DB_NAME);
        if($conn->connect_error){
            return null;
        } else {
            return $conn;
        }
    }

    public function selectNotes()
    {
        $conn = $this->connect();
        $result = array();
        $query = mysqli_query($conn, "SELECT id, nama_produk, harga, gambar, deskripsi FROM product");

        if($query->num_rows>0){
            while($row = mysqli_fetch_assoc($query)){
                $result[] = $row;
            }
            echo json_encode(array('result'=> $result));
        } else{
            echo json_encode(array('result'=> 'data tidak ditemukan'));
        }
    }

    public function handleRequest()
    {
        if(isset($_POST['nama'])){
            // $this->insertNotes();
        } else {
            $this->selectNotes();
        }
    }

}

?>