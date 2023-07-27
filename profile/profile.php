<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Ajax</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container p-0">
        <div class="form-container mt-5 p-5">
            <form action="profile.php" method="post" class="the-form p-3 p-md-5" id="profileForm">
                <div class="row">
                    <h1 class="heading-1 mb-5 text-center">Add Profile</h1>
                </div>
                <div class="row col-lg-12 m-0 p-0">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control autofocus" name="full_name" id="full_name" placeholder="Full Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="email_address">Email Address</label>
                            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Email Address">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="birthday">Date of Birth</label>
                            <input type="date" class="form-control" name="birthday" id="birthday" placeholder="Birthday">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" min="0" class="form-control" value="0" name="age" id="age" placeholder="Age" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="Ex.: 09991234567">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" id="submit_btn" class="btn w-100 btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            
            $("#birthday").change(function() {
                var birthDate = new Date($(this).val());
                var age = calculateAge(birthDate);
                $("#age").val(age);
            });

            function calculateAge(birthDate) {
                var today = new Date();
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }

            $("#submit_btn").click(function(e) {
                e.preventDefault();
                var mobile_number = $("#mobile_number").val();
                var full_name = $("#full_name").val();
                var email_address = $('#email_address').val();
                var birthday = $('#birthday').val();
                var age = $('#age').val();
                var gender = $('#gender').val();
                var pattern_of_mobile_number = /^09\d{9}$/;
                var pattern_of_full_name = /^[a-zA-Z,.\s]+$/;
                var pattern_of_email_address = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (!pattern_of_mobile_number.test(mobile_number)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Invalid phone number',
                        text: "Phone number should start with '09' and be 11 characters long.",
                        confirmButtonText: 'OK'
                    });
                } else if (!pattern_of_full_name.test(full_name)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Invalid Full Name',
                        text: 'Only letters, comma, and period characters are allowed.',
                        confirmButtonText: 'OK'
                    });
                } else if (!pattern_of_email_address.test(email_address)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Invalid Email address',
                        text: 'Please input a valid email address.',
                        confirmButtonText: 'OK'
                    });
                } else if (birthday === '') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Invalid Date of Birth',
                        text: 'Please input a valid Date of Birth.',
                        confirmButtonText: 'OK'
                    });
                } else if (age === '') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Invalid Age',
                        text: 'Please input a valid Age.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: 'server.php',
                        data: {
                            mobile_number: mobile_number,
                            full_name: full_name,
                            email_address: email_address,
                            birthday: birthday,
                            age: age,
                            gender: gender,
                        },
                        success: function(data)
                        {
                            var returnedData = JSON.parse(data);
                            Swal.fire({
                                icon: 'info',
                                title: returnedData.status,
                                text: returnedData.message,
                                confirmButtonText: 'OK'
                            });
                            $("#mobile_number").val('');
                            $("#full_name").val('');
                            $('#email_address').val('');
                            $('#birthday').val('');
                            $('#age').val('');
                            $('#gender').val('');
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>