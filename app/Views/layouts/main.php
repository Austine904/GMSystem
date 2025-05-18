<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


    <title>GarageMS</title>


</head>

<body>

    <!-- Sidebar Navigation -->
    <?= $this->include('partials/sidebar'); ?>

    <!-- Main Content -->
    <div style="margin-left: 250px;">
        <?= $this->renderSection('content'); ?>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

</body>

<footer class="bg-light text-dark text-center py-3 mt-auto ">
    <div class="container">
        <p>Developed by Austine</p>
        <small>&copy; <?= date('Y') ?> Garage Management System. All rights reserved.</small>
    </div>
</footer>

</html>