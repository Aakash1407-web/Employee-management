<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{

    public function index()
    {
        $this->load->model('EmployeeModel');
        $encodedData = $this->input->get('data');
        if ($encodedData !== null) {
            $decodedData = json_decode(base64_decode(urldecode($encodedData)), true);
            if (!empty($decodedData)) {

                $id = $decodedData;
                $where = array('id' => $id);
                $data['empdata'] = $this->EmployeeModel->getSingleRowByWhere('employee', $where);
                $this->load->view('add_employee', $data);
            } else {
                $this->load->view('add_employee');
            }
        } else {
            $this->load->view('add_employee');
        }
    }



    public function addEmployee()
    {


        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            if (!empty($_POST['emp_id'])) {

                $id = $_POST['emp_id'];
                // Fetch old employee data
                $where = array('id' => $id);
                $empdata = $this->EmployeeModel->getSingleRowByWhere('employee', $where);



                $updatedata = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'mobile_country_code' => $_POST['mobile_country_code'],
                    'mobile_number' => $_POST['mobile_number'],
                    'address' => $_POST['address'],
                    'gender' => $_POST['gender'],
                    'hobby' => implode(',', $_POST['hobby']),
                    'image' => $empdata->image, //(if new image is empty than old image is get)
                );

                // Check if a new image is uploaded
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/employeeimages/';
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid() . '_' . time() . '.' . $extension;
                    $uploadFile = $uploadDir . $uniqueName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        // Update with the new image
                        $updatedata['image'] = $uniqueName;
                    }
                }
                $EmployeeData = $this->EmployeeModel->updateRecord('employee', $updatedata, $where);

                if ($EmployeeData) {
                    $response = array(
                        'status' => 'successes',
                        'message' => 'Employee data updated successfully.'
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to update employee data.'
                    );
                }
            } else {
                $data = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'mobile_country_code' => $_POST['mobile_country_code'],
                    'mobile_number' => $_POST['mobile_number'],
                    'address' => $_POST['address'],
                    'gender' => $_POST['gender'],
                    'hobby' => implode(',', $_POST['hobby']),
                    'image' => null,
                );
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/employeeimages/';
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid() . '_' . time() . '.' . $extension;
                    $uploadFile = $uploadDir . $uniqueName;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                        $data['image'] = $uniqueName;
                    }
                }
                $EmployeeData = $this->EmployeeModel->insertAll('employee', $data);
                if ($EmployeeData) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Employee data inserted successfully.'
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Failed to insert employee data.'
                    );
                }
            }



            echo json_encode($response);
        }
    }

    public function displayEmployees()
    {
        $data['employeelist'] = $this->EmployeeModel->getAll('employee', 'id', 'asc');
        $this->load->view('show_employee', $data);
    }



    public function deleteEmployee()
    {
        if ($_POST['id']) {
            $where = array('id' => $_POST['id']);
            $empdata = $this->EmployeeModel->deleteAll('employee', $where);
            if ($empdata) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Employee deleted successfully.'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to delete employee.'
                );
            }

            echo json_encode($response);
        }
    }
}
