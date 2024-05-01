<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<style>
    .error {
        color: red;
    }
</style>


<body>
    <div class="container">
        <div style="margin-left: 602px;margin-top: 12px;">
            <a href="<?php echo base_url('index.php/Employee/displayEmployees') ?>">
                <button class="btn btn-primary">All Employee List</button>
            </a>

        </div>
        <h2>Add New Employee</h2>
        <form id="employeeForm" method="post">

            <input type="hidden" name="emp_id" id="emp_id" value="<?= @$empdata->id ?>">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= @$empdata->first_name ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= @$empdata->last_name ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= @$empdata->email ?>">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mobile_country_code">Mobile Country Code:</label>
                    <select class="form-control" id="mobile_country_code" name="mobile_country_code">
                        <option value="">Select Country</option>
                        <option value="+91" <?php echo (@$empdata->mobile_country_code == '+91') ? 'selected' : ''; ?>>+91 (India)</option>
                        <option value="+1" <?php echo (@$empdata->mobile_country_code == '+1') ? 'selected' : ''; ?>>+1 (USA)</option>
                        <option value="+44" <?php echo (@$empdata->mobile_country_code == '+44') ? 'selected' : ''; ?>>+44 (UK)</option>
                        <option value="+86" <?php echo (@$empdata->mobile_country_code == '+86') ? 'selected' : ''; ?>>+86 (China)</option>
                    </select>

                </div>
                <div class="form-group col-md-6">
                    <label for="mobile_number">Mobile Number:</label>
                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number" value="<?= @$empdata->mobile_number ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="4" cols="50"><?= isset($empdata->address) ? $empdata->address : '' ?></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="male" name="gender" value="male" <?php echo (@$empdata->gender == 'male') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="female" name="gender" value="female" <?php echo (@$empdata->gender == 'female') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="female">Female</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="other" name="gender" value="other" <?php echo (@$empdata->gender == 'other') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="other">Other</label>
            </div>
            <div class="form-group">
                <label>Hobby:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="hobby1" name="hobby[]" value="reading" <?php echo (isset($empdata->hobby) && strpos($empdata->hobby, 'reading') !== false) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="hobby1">Reading</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="hobby2" name="hobby[]" value="sports" <?php echo (isset($empdata->hobby) && strpos($empdata->hobby, 'sports') !== false) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="hobby2">Sports</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="hobby3" name="hobby[]" value="music" <?php echo (isset($empdata->hobby) && strpos($empdata->hobby, 'music') !== false) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="hobby3">Music</label>
                </div>
            </div>


            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <input type="hidden" class="form-control" id="old_image" name="old_image" value="<?php echo isset($empdata->image) ? $empdata->image : ''; ?>">
                <div>

                    <?php
                    $image = isset($empdata->image) ? 'uploads/employeeimages/' . $empdata->image : '';
                    ?>
                    <?php if (!empty($image)) : ?>
                        <img src="<?php echo base_url($image) ?>" height="30" width="30">
                    <?php endif; ?>

                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        $('#mobile_country_code').change(function() {
            var mobile_country_code = $(this).val();
            var placeholder = '';
            switch (mobile_country_code) {
                case '+1':
                    placeholder = 'Enter US mobile number';
                    break;
                case '+44':
                    placeholder = 'Enter UK mobile number';
                    break;
                case '+91':
                    placeholder = 'Enter Indian mobile number';
                    break;
                case '+86':
                    placeholder = 'Enter China mobile number';
                    break;
                default:
                    placeholder = 'Enter mobile number';
                    break;
            }
            $('#mobile_number').attr('placeholder', placeholder);
        });
    });


    $(document).ready(function() {

        $("#employeeForm").validate({
            rules: {
                first_name: {
                    required: true
                },
                email: {
                    required: true
                },
                mobile_country_code: {
                    required: true
                },
                mobile_number: {
                    required: true,
                    digits: true
                },


            },
            messages: {
                first_name: {
                    required: 'Please enter First Name'
                },
                email: {

                    required: 'Please enter Email'
                },
                mobile_country_code: {
                    required: 'Please select Country Code'
                },
                mobile_number: {
                    required: 'Please enter Mobile Number',
                    digits: 'Please enter a valid Mobile Number'
                },


            }
        });

        $('#employeeForm').submit(function(event) {
            event.preventDefault();

            // Check if the form is valid
            if ($(this).valid()) {

                var formData = new FormData($(this)[0]);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('index.php/Employee/addEmployee'); ?>',
                    data: formData,
                    contentType: false,
                    processData: false,
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
                            $('#employeeForm')[0].reset();
                        } else if (data.status === 'successes') {

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
                            // Show error message using SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message
                            });
                        }

                    },
                    error: function(xhr, status, error) {}
                });
            }
        });
    });
</script>