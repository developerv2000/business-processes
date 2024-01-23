<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Model Viewer</title>
    <!-- Include the model-viewer library -->
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>

    <style>
        model-viewer {
            width: 800px;
            height: 800px;
        }
    </style>
</head>

<body>
    <!-- Use the model-viewer tag to embed the 3D model -->
    <div style="display: flex; justify-content: center;">
        <model-viewer src="{{ asset('img/main/3dd.glb') }}" alt="A 3D model" camera-controls auto-rotate ar ar-modes="webxr scene-viewer quick-look" ar-scale="auto"></model-viewer>
    </div>
</body>

</html>
