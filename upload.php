<?php
putenv("HOME=/var/www");
putenv("OCI_CLI_AUTH=api_key");

$bucket = "bucket-20250521-1835";
$namespace = "idyhabl91i8j";
$config_path = "/var/www/.oci/config";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target = "/tmp/" . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo "<p style='color: green;'>✅ File uploaded to server. Now uploading to Object Storage...</p>";

        $cmd = "sudo /home/ubuntu/bin/oci os object put --bucket-name $bucket --file $target --namespace $namespace --config-file $config_path";
        $output = shell_exec($cmd);

        echo "<pre style='background-color: #f4f4f4; padding: 10px; border-radius: 5px;'>$output</pre>";
    } else {
        echo "<p style='color: red;'>❌ File upload failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload to OCI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 50px;
        }
        .upload-box {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
            margin: auto;
            text-align: center;
        }
        input[type="file"] {
            margin-bottom: 15px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background: #0073e6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #005bb5;
        }
    </style>
</head>
<body>
    <div class="upload-box">
        <h2>📤 Upload File to OCI</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" required /><br>
            <input type="submit" value="Upload" />
        </form>
    </div>
</body>
</html>
