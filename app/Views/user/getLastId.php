<!DOCTYPE html>
<html>
<head>
    <title>Get Last User ID</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<button id="fetchLastId">Get Last User ID</button>
<p>Last User ID: <span id="lastIdDisplay">Not Fetched</span></p>

<script>
    $(document).ready(function() {
        $('#fetchLastId').click(function() {
            $.ajax({
                url: "<?= base_url('user/getLastId') ?>", // Adjust URL if your route is different
                type: 'GET',
                success: function(response) {
                    $('#lastIdDisplay').text(response.id);
                },
                error: function() {
                    alert('Failed to fetch last user ID.');
                }
            });
        });
    });
</script>

</body>
</html>
