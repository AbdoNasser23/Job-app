
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Cloudinary</title>
</head>
<body>
    <h2>Upload CV PDF</h2>

    <form action="{{ url('/test-cloudinary') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <input type="file" name="cv_file"
               accept=".pdf" required>

        <button type="submit">Upload CV</button>
    </form>
</body>
</html>
