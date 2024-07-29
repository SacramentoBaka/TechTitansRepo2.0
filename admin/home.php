<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #e6f2e0; /* Mint green background */
            color: #367952; /* Dark green text */
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #367952; /* Dark green text */
            font-weight: bold;
        }

        hr.border-primary {
            border-color: #246dec; /* Primary color for the border */
        }

        #website-cover {
            width: 100%;
            height: 30em;
            object-fit: cover;
            object-position: center center;
        }

        .info-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #d2d2d3;
            border-radius: 5px;
            box-shadow: 0 6px 7px -4px rgba(0, 0, 0, 0.2), 0 0 10px rgba(0, 128, 0, 0.5); /* Glowing effect */
            margin-bottom: 20px;
            opacity: 0; /* Start hidden */
        }

        .info-box-icon {
            font-size: 24px;
            padding: 15px;
            border-radius: 50%;
            background-color: white;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #246dec, #ffffff);
        }

        .bg-gradient-teal {
            background: linear-gradient(135deg, #20c997, #ffffff);
        }

        .bg-gradient-maroon {
            background: linear-gradient(135deg, #e74c3c, #ffffff);
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-text {
            font-size: 16px;
            color: black; /* Dark green text */
        }

        .info-box-number {
            font-size: 24px;
            font-weight: 600;
            color: black; /* Adjust according to your design */
        }

        /* Keyframe animation for sliding effect */
        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 1s forwards;
        }
    </style>
</head>
<body>

    <h1 class="font-weight-bold">Welcome to <?php echo $_settings->info('name') ?></h1>
    <hr class="border-primary">

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-primary shadow">
                <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Categories</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `category_list` where delete_flag= 0 and `status` = 1 ")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-teal shadow">
                <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-file-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Policies</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `policy_list` where `status` = 1 ")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-maroon shadow">
                <span class="info-box-icon bg-gradient-maroon elevation-1"><i class="fas fa-file-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Inactive Policies</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `policy_list` where `status` = 0 ")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-primary shadow">
                <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Clients</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `client_list` ")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-3">
            <div class="info-box bg-gradient-teal shadow">
                <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Insured Vehicle</span>
                    <span class="info-box-number text-right">
                        <?php 
                            echo $conn->query("SELECT * FROM `insurance_list` where `status` = 1 and date(expiration_date) > '".(date("Y-m-d"))."' ")->num_rows;
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            <img src="<?= validate_image($_settings->info('cover')) ?>" alt="Website Cover" class="img-fluid border w-100" id="website-cover">
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const boxes = document.querySelectorAll(".info-box");
            boxes.forEach((box, index) => {
                setTimeout(() => {
                    box.classList.add("slide-in");
                }, index * 1000); // 5 seconds delay between each box
            });
        });
    </script>

</body>
</html>
