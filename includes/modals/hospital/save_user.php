<?php
session_start();
include_once("../../../includes/config.php");

require_once "vendor/autoload.php"; // Assuming PHPMailer is installed via Composer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateSalt($length = 16) { // Adjust salt length as needed
    $randomBytes = random_bytes($length);
    return bin2hex($randomBytes); // Or use base64_encode($randomBytes)
}

$AdminID = $_SESSION['admin_id'] ?? '';
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first-name'] ?? '';
    $middleName = $_POST['middle-name'] ?? '';
    $lastName = $_POST['last-name'] ?? '';
    $hospitalID = $_POST['user-hospital'] ?? '';
    $position = $_POST['position'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($firstName) && !empty($lastName) && !empty($hospitalID) && !empty($position) && !empty($email) && !empty($password)) {

        // Check if the user already exists
        $queryCheckUser = "SELECT COUNT(*) FROM repo_user WHERE email = $1";
        $resultCheckUser = pg_query_params($db_connection, $queryCheckUser, array($email));
        $count = pg_fetch_result($resultCheckUser, 0, 0); // Fetch the count properly

        if ($count > 0) {
          $_SESSION['user-created'] = "Email Already Exist";
          header("location: /user-information.php");
          exit;
            exit;
        }
        
        $query = "INSERT INTO repo_user (admin_id, hospital_id, user_fname, user_mname, user_lname, position, email, password) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        
        $result = pg_prepare($db_connection, "insert_query", $query);

        if ($result) {
            $result_exec = pg_execute($db_connection, "insert_query", array($AdminID, $hospitalID, $firstName, $middleName, $lastName, $position, $email, $password));

            if ($result_exec) {
                $_SESSION['add-user'] = "New user added successfully!";
                $_SESSION['user_lname'] = $lastname;

                // Fetch user data
                $queryUser = "SELECT user_lname FROM repo_user WHERE admin_id = $1";
                $resultUser = pg_query_params($db_connection, $queryUser, array($AdminID));
                $userData = pg_fetch_assoc($resultUser);

                // Send email with the verification code
                $subject = ucfirst($userData['user_lname']) . ', here\'s your PCC Account:';
                $message = '<!DOCTYPE html>
                <html lang="en">
                <head>
                  <meta charset="UTF-8" />
                  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                  <title>Email Template</title>
                </head>
                <body style="font-family: sans-serif; background-color: #e5e6e6; font-size: 15px; max-width: 500px; margin: 0 auto; padding: 3%; width: 100%;">
                  <div style="background-color: #f0f6fb; padding: 3%;">
                    <header style="width: 100%; display: flex; justify-content: center; align-items: center; max-width: 400px; margin: 0 auto;">
                      <div style="max-width: 90px; display: block;
                      margin-left: auto;
                      margin-right: auto;
                      width: 50%;">
                      <img src="https://scontent.fmnl25-1.fna.fbcdn.net/v/t1.15752-9/252886612_256735746427586_7182999434579212748_n.png?_nc_cat=108&ccb=1-7&_nc_sid=8cd0a2&_nc_eui2=AeHtYI1q7JwWlH56E17XOzQbponiEfJxo3umieIR8nGje3DEsZex004VfUKiUTjFP1qten1ARjntEBwWsufCYMIu&_nc_ohc=5ECfnLfH8e4AX8rJ0id&_nc_ht=scontent.fmnl25-1.fna&oh=03_AdRJKGihLEO5szcROVytb5thunrm8KqvrfDNz6xGphbPmw&oe=65952504" alt="" style="max-width: 100%; display: block; margin: 0 auto; margin-bottom: 10px;">
                      </div>
                      <div>
                        <ul style="float: right; margin: 0; padding: 0; list-style-type: none;">
                          <!-- Add your social links here -->
                        </ul>
                      </div>
                    </header>
                    <div style="padding: 0 0 3% 0;">
                      <hr style="background-color: #d8dada; margin: auto;">
                      <div style="margin: 3%;">
                        <h1 style="font-weight: bold; margin: 3%; font-style: normal;">Hi, ' . " " . $lastName . '</h1>
                        <p style="margin: 3%; font-style: normal;">This email is to inform you that your account has been successfully created. Below are your account details:</p>
                        <p style="margin: 3%; font-style: normal;">Email: <span style="font-weight: bold;">'. $email . '</span></p>
                        <p style="margin: 3%; font-style: normal;">Password: <span style="font-weight: bold;">' . $password . '</span></p>
                        <p style="margin: 3%; font-style: normal;"><a href="http://localhost:3000/login.php" style="font-style: normal;">Click here to login your account</a></p>
                        <p style="margin: 3%; font-style: normal;">We recommend logging in to your account using the provided credentials. Once logged in, we advise changing your password immediately for security reasons.
                        </p>
                        <p style="margin: 3%; font-style: normal;">If you encounter any issues or have any questions, feel free to reach out to our support team for assistance.</p>
                        <p style="margin: 3%; font-style: normal;">The PCC Team.</p>
                        <hr style="background-color: #d8dada; margin: auto;">
                        <div style="text-align: center; color: red; margin: 3%; font-style: normal;">
                          Note: This message is system-generated. Please do not reply.
                        </div>
                        <footer style="text-align: center; padding-bottom: 3%; line-height: 16px; font-size: 12px; color: #303840;">
                          <p>
                            @2023 Philippine Cancer Center <br />
                            6512 Quezon Avenue, Lung Center<br />
                            of the Philippines Compound Diliman,<br />
                            Quezon City, 1011
                          </p>
                        </footer>
                      </div>
                    </div>
                  </div>
                </body>
                </html>       
            ';

                $mail = new PHPMailer(true);

                // SMTP Configuration
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->Username = "noreplyphilippinecancercenter@gmail.com";
                $mail->Password = "hxrywczoqmcjqdhe";

                // Sender and recipient settings
                $mail->setFrom("noreplyphilippinecancercenter@gmail.com", "PCC");
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;

                // Send email
                try {
                    $mail->send();
                    header("Location: /user-information.php");
                    exit();
                } catch (Exception $e) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
            } else {
                echo "Error executing query: " . pg_last_error($db_connection);
            }
        } else {
            echo "Error preparing query: " . pg_last_error($db_connection);
        }
    } else {
        echo "Required fields are missing.";
    }
}
?>
