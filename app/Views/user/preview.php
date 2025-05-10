
<div class="container mt-5">
    <h3>Review & Submit</h3>
    <hr>

    <h5>Company Information</h5>
    <p><strong>Full Name:</strong> <?= $step1Data['first_name'] . ' ' . $step1Data['last_name'] ?></p>
    <p><strong>Email:</strong> <?= $step1Data['email'] ?></p>
    <p><strong>Phone:</strong> <?= $step1Data['phone_number'] ?></p>
    <p><strong>Role:</strong> <?= $step1Data['role'] ?></p>
    <p><strong>Company ID:</strong> <?= $step1Data['company_id'] ?></p>
    <p><strong>Date Employed:</strong> <?= $step1Data['date_employed'] ?></p>
    <hr>

    <h5>Personal Information</h5>
    <p><strong>Date of Birth:</strong> <?= $step2Data['dob'] ?></p>
    <p><strong>National ID Number:</strong> <?= $step2Data['id_number'] ?></p>
    <hr>

    <h5>Next of Kin Information</h5>
    <p><strong>Full Name:</strong> <?= $step3Data['kin_first_name'] . ' ' . $step3Data['kin_last_name'] ?></p>
    <p><strong>Relationship:</strong> <?= $step3Data['relationship'] ?></p>
    <p><strong>Phone:</strong> <?= $step3Data['kin_phone'] ?></p>

    <hr>

    <form action="<?= base_url('user/submit') ?>" method="post">
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>