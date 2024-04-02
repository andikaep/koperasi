<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="<?php echo base_url('assetAdmin/')?>dist/css/tailwind.min.css">
    <style>
        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce {
            0%,
            100% {
                transform: translateY(-20px);
            }

            50% {
                transform: translateY(0);
            }
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }
        @keyframes shake {
            0% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            50% {
                transform: translateX(5px);
            }
            75% {
                transform: translateX(-5px);
            }
            100% {
                transform: translateX(0);
            }
        }
        @keyframes fade {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .fade {
            animation: fade 1.5s ease-in-out;
        }

        .pulse {
            animation: pulse 2s infinite;
        }
        .shake {
            animation: shake 0.5s ease-in-out infinite;
        }
        .rotate {
            animation: rotate 3s linear infinite;
        }

        .bounce {
            animation: bounce 1s ease-in-out infinite;
        }

        .fadeInOut {
            animation: fadeInOut 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-white text-blue-600 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-9xl font-bold mb-4 rotate">404</h1>
        <p class="text-3xl mb-8 bounce">Not Found</p>
        <p class="text-1xl mb-8 pulse">Anda tersesat, segera kembali</p>
        <a href="Dashboard" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full inline-block">Back to Home</a>
    </div>
</body>

</html>
