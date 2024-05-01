<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List of Employee</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
</head>
<div style="margin-left: 602px;margin-top: 12px;">
  <a href="<?php echo base_url('index.php/Employee/index') ?>">
    <button class="btn btn-primary">Add Employee</button>
  </a>

</div>

<body>

  <table class="table" id="employeeTable">
    <thead>
      <tr>
        <th scope="col">Sn.</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email</th>
        <th scope="col">Mobile Country Code</th>
        <th scope="col">Mobile Number</th>
        <th scope="col">Address</th>
        <th scope="col">Gender</th>
        <th scope="col">hobby</th>
        <th scope="col">image</th>
        <th scope="col">Action</th>

      </tr>
    </thead>
    <tbody>
      <?php $i = 1;
      foreach ($employeelist as $val) {
        $encrypted_employee_id = urlencode(base64_encode(json_encode($val->id)));
        $image = 'uploads/employeeimages/' . $val->image;
      ?>
        <tr>
          <th scope="row"><?= $i ?></th>
          <td><?= $val->first_name ?></td>
          <td><?= $val->last_name ?></td>
          <td><?= $val->email ?></td>
          <td><?= $val->mobile_country_code ?></td>
          <td><?= $val->mobile_number ?></td>
          <td><?= $val->address ?></td>
          <td><?= $val->gender ?></td>
          <td><?= $val->hobby ?></td>
          <td>
            <?php if (!empty($val->image) && ($val->image != Null)) { ?>
              <img src="<?php echo base_url($image) ?>" alt="Employee Image" height="30" width="30">
            <?php  }     ?>


          </td>
          <td><a href="<?php echo base_url('index.php/Employee/index') . '?data=' . $encrypted_employee_id; ?>">
              <button type="button" class="btn btn-primary">Edit</button>
            </a>

            <button class="btn btn-danger" onclick="EmployeeDelete(<?= $val->id ?>)" style="margin-top: 7px;">Delete</button>



          </td>
        </tr>
      <?php $i++;
      } ?>


    </tbody>
  </table>



</body>

</html>
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>
<script>
  $(document).ready(function() {
    $('#employeeTable').DataTable({
      responsive: true // Enable responsive feature
    });
  });

  function EmployeeDelete(id) {
    // Show a confirmation dialog using Swal.fire
    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to delete?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('index.php/Employee/deleteEmployee'); ?>',
          data: {
            id: id
          },
          success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
              // Show success message using SweetAlert
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                showConfirmButton: false,
                timer: 2000
              });
              setTimeout(function() {
                location.reload();
              }, 2000);
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message
              });
            }
          },

        });

        setTimeout(function() {
          location.reload();
        }, 2000); // Reload after 2 seconds (you can adjust this delay)
      }
    });
  }
</script>