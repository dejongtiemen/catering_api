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
        $location_ID = $data['location_ID'];

        $query = "INSERT INTO facility (name, creation_date, location_ID)
        VALUES ('$facility_name',' $facility_creation_date', '$location_ID')";

        if ($facility_name != null && $facility_creation_date != null && $location_ID != null) {
            try {
                $this->db->executeQuery($query, []);
                $rowcount = $this->db->getStatement()->rowCount();

            } catch (PDOException $Exception) {
                (new Status\BadRequest(['message' => $Exception]))->send();
                exit;
            }

            if ($rowcount > 0) {
                (new Status\Created(['message' => 'Item is created']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Unable to create item.']))->send();
            }
        } else {
            (new Status\BadRequest(['message' => 'Unable to create item.']))->send();
        }
    }

    public function createLocation($city, $address, $zip_code, $country_code, $phone_number)
    {
        $query = "INSERT IGNORE INTO location (city, address, zip_code, country_code, phone_number) 
        VALUES ('$city', '$address', '$zip_code', '$country_code', '$phone_number')";
        $this->db->executeQuery($query, []);
    }

    public function createTag($name)
    {
        foreach ($name as $value) {
            $query = "INSERT IGNORE INTO tag (name) 
        VALUES ('$value')";
            $this->db->executeQuery($query, []);
        }
    }

    public function createFacilityTag()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $facility_name = $data['name'];
        $tag_name = $data['tag_name'];

        if ($facility_name != null && $tag_name != null) {
            try {
                $query = "INSERT IGNORE INTO tag (name) 
                VALUES ('$tag_name')";
                $this->db->executeQuery($query, []);

                $query = "SELECT facility_ID FROM facility WHERE name = '$facility_name'";
                $this->db->executeQuery($query, []);
                $result = $this->db->getStatement()->fetch(\PDO::FETCH_ASSOC);
                $facility_ID = $result['facility_ID'];


                if ($facility_ID != null) {
                    $query = "INSERT INTO facility_tag (facility_ID, tag_name) VALUES ($facility_ID, '$tag_name')";
                    $this->db->executeQuery($query, []);
                }
                $rowcount = $this->db->getStatement()->rowCount();

            } catch (PDOException $Exception) {
                (new Status\BadRequest(['message' => $Exception]))->send();
                exit;
            }

            if ($rowcount > 0) {
                (new Status\Created(['message' => 'Item is created']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Unable to create item2.']))->send();
            }
        } else {
            (new Status\BadRequest(['message' => 'Unable to create item.']))->send();
        }

    }

    public function readFacility()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $facility_name = $data['name'];

        if ($facility_name != null) {
            foreach ($facility_name as $value) {

                $query = "SELECT f.name, f.creation_date, l.address, l.city, l.country_code, l.zip_code, l.phone_number, ft.tag_name
                FROM facility as f
                LEFT JOIN location as l
                ON l.ID = f.location_ID 
                LEFT JOIN facility_tag as ft
                ON ft.facility_ID = f.facility_ID
                WHERE f.name = '$value'";

                $this->db->executeQuery($query, []);
                $result = $this->db->getStatement()->fetchAll(\PDO::FETCH_ASSOC);
                $rowcount = $this->db->getStatement()->rowCount();

                if ($rowcount > 0) {
                    (new Status\Ok(['message' => $result]))->send();
                } else {
                    (new Status\BadRequest(['message' => 'read facility failed']))->send();
                }
            }
        } else {
            (new Status\BadRequest(['message' => 'read facility failed']))->send();
        }
    }


    public function updateFacilityName()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $updated_facility_name = $data['updated_facility_name'];
        $facility_name = $data['facility_name'];

        if ($updated_facility_name != null && $facility_name != null) {
            $query = "UPDATE facility SET name = '$updated_facility_name' 
            WHERE name = '$facility_name'";

            $this->db->executeQuery($query, []);
            $result = $this->db->getStatement()->rowCount();

            if ($result > 0) {
                (new Status\Created(['message' => 'Facility name is updated']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Failed to update facility name']))->send();
            }
        } else {
            (new Status\BadRequest(['message' => 'Failed to update facility name']))->send();
        }
    }

    public function updateFacilityCreationDate()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $facility_name = $data['facility_name'];
        $creation_date = $data['creation_date'];

        if ($facility_name != null && $creation_date != null) {
            $query = "UPDATE facility SET creation_date = '$creation_date' 
        WHERE name = '$facility_name'";

            $this->db->executeQuery($query, []);
            $result = $this->db->getStatement()->rowCount();

            if ($result > 0) {
                (new Status\Created(['message' => 'Facility creation date is updated']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Failed to update facility creation date']))->send();
            }
        } else {
            (new Status\BadRequest(['message' => 'Failed to update facility creation date']))->send();
        }
    }


    public function deleteFacilityTag()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $tag_name = $data['tag_name'];
        $facility_ID = $data['facility_ID'];

        if ($tag_name != null && $facility_ID != null) {
            $query = "DELETE FROM facility_tag WHERE tag_name = '$tag_name' AND facility_ID = '$facility_ID'";

            $this->db->executeQuery($query, []);
            $result = $this->db->getStatement()->rowCount();

            if ($result > 0) {
                (new Status\Ok(['message' => 'Deleted facility tag']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Failed to delete facility tag']))->send();
            }
        } else {
            (new Status\BadRequest(['message' => 'Failed to delete facility tag']))->send();
        }
    }

    public function deleteFacility()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $facility_name = $data['name'];

        if ($facility_name != null) {
            $query = "DELETE FROM facility WHERE name = '$facility_name'";
            $this->db->executeQuery($query, []);
            $result = $this->db->getStatement()->rowCount();

            if ($result > 0) {
                (new Status\Ok(['message' => 'Deleted facility']))->send();
            } else {
                (new Status\BadRequest(['message' => 'Failed to delete facility']))->send();
            }
        } else {
            (new Status\BadRequest(['message' => 'Failed to delete facility']))->send();
        }
    }

    public function searchFacility()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $facility_name = $data['facility_name'];
        $tag_name = $data['tag_name'];
        $location_city = $data['location_city'];

        $query = "SELECT f.name, f.creation_date, l.address, l.city, l.country_code, l.zip_code, l.phone_number, ft.tag_name
        FROM facility as f
        LEFT JOIN location as l
        ON l.ID = f.location_ID 
        LEFT JOIN facility_tag as ft
        ON ft.facility_ID = f.facility_ID
        WHERE ";

        if ($facility_name != null && $tag_name != null && $location_city != null) {
            $query .= " (f.name LIKE '%$facility_name%' AND l.city LIKE '%$location_city%'AND ft.tag_name LIKE '&$tag_name&')";
        } 
        elseif ($facility_name != null && $tag_name != null) {
            $query .= "(f.name LIKE '%$facility_name%' AND ft.tag_name LIKE '&$tag_name&')";
        } 
        elseif ($tag_name != null && $location_city != null) {
            $query .= "(ft.tag_name LIKE '&$tag_name&' AND l.city LIKE '%$location_city%')";
        } 
        elseif ($facility_name != null && $location_city != null) {
            $query .= "(f.name LIKE '%$facility_name%' AND l.city LIKE '%$location_city%')";
        } 
        elseif ($facility_name != null) {
            $query .= "f.name LIKE '%$facility_name%'";
        } 
        elseif ($tag_name != null) {
            $query .= "ft.tag_name LIKE '&$tag_name&'";
        } 
        elseif ($location_city != null) {
            $query .= "l.city LIKE '%$location_city%'";
        } else {
            (new Status\BadRequest(['message' => 'Failed to search a facility']))->send();
            exit;
        }

        $this->db->executeQuery($query, []);
        $result = $this->db->getStatement()->fetchAll(\PDO::FETCH_ASSOC);
        $rowcount = $this->db->getStatement()->rowCount();

        if ($rowcount > 0) {
            (new Status\Ok(['message' => $result]))->send();
        } else {
            (new Status\BadRequest(['message' => 'read facility failed']))->send();
        }


    }


}
?>