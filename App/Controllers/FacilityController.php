<?php
namespace App\Controllers;

use PDOException;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

use App\Plugins\Http\Response as Status;
use App\Plugins\Http\Exceptions;


class FacilityController extends BaseController
{


    public function createFacility()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $facility_name = $data['name'];
        $facility_creation_date = date("y-m-d");
        $facility_city = $data['facility_city'];
        $facility_adsress = $data['facility_address'];
        $facility_zip_code = $data['facility_zip_code'];
        $facility_country_code = $data['facility_country_code'];

        $this->createLocation($facility_city, $facility_adsress, $facility_zip_code, $facility_country_code);


        $query = "INSERT INTO `facility`(`name`, `creation_date`, `facility_city`, `facility_address`, `facility_zip_code`, `facility_country_code`)
        VALUES ('$facility_name',' $facility_creation_date','$facility_city','$facility_adsress','$facility_zip_code','$facility_country_code')";


        try {
            $result = $this->db->executeQuery($query, []);
        } catch (PDOException $Exception) {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create item."));
            exit;
        }

        if ($result == true) {
            http_response_code(201);
            echo json_encode(array("message" => "Item was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create item."));
        }
    }

    public function createLocation($city, $address, $zip_code, $country_code)
    {
        $query = "INSERT IGNORE INTO location (city, address, zip_code, country_code) 
        VALUES ('$city', '$address', '$zip_code', '$country_code')";
        $result = $this->db->executeQuery($query, []);
    }

    public function readFacility()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $facility_name = $data['name'];

        $query = "SELECT * from facility where name = '$facility_name'";

        $this->db->executeQuery($query, []);
        $result = $this->db->getStatement()->fetchAll(\PDO::FETCH_ASSOC);

        if ($result != null) {
            echo json_encode($result);
        } else {
            echo json_encode(['msg' => 'No Data!', 'status' => false]);
        }
    }

    public function readFacilities()
    {
       
    }

    public function updateFacility()
    {

    }

    public function deleteFacility()
    {

    }


}
?>