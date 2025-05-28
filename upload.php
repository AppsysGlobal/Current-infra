<?php
putenv("HOME=/var/www");
putenv("OCI_CLI_AUTH=api_key");

$bucket = "bucket-20250521-1835";
$namespace = "idyhabl91i8j";
$config_path = "/var/www/.oci/config";

$message = "";
$output = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target = "/tmp/" . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $message = "<p class='success'>✅ File uploaded to server. Now uploading to Object Storage...</p>";

        $cmd = "sudo /home/ubuntu/bin/oci os object put --bucket-name $bucket --file $target --namespace $namespace --config-file $config_path";
        $output = shell_exec($cmd);
    } else {
        $message = "<p class='error'>❌ File upload failed.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload to OCI</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ece9e6, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .upload-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 450px;
        }
        .upload-icon {
            font-size: 50px;
            color: #0073e6;
            margin-bottom: 20px;
        }
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            cursor: pointer;
            display: inline-block;
            background: #f0f0f0;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        .custom-file-upload:hover {
            background: #d6e9ff;
            color: #0073e6;
        }
        input[type="submit"] {
            background: #0073e6;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #005bb5;
        }
        .success {
            color: green;
            margin-top: 20px;
        }
        .error {
            color: red;
            margin-top: 20px;
        }
        pre {
            background-color: #f8f8f8;
            padding: 10px;
            border-radius: 5px;
            text-align: left;
            margin-top: 15px;
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="upload-box">
        <div class="upload-icon">📤</div>
        <h2>Upload File to OCI</h2>
        <form method="post" enctype="multipart/form-data">
            <label class="custom-file-upload">
                <input type="file" name="file" onchange="this.form.submit()" required />
                Choose a file
            </label><br>
            <input type="submit" value="Upload" />
        </form>
        <?= $message ?>
        <?php if ($output): ?>
            <pre><?= htmlspecialchars($output) ?></pre>
        <?php endif; ?>
    </div>
</body>
</html>
