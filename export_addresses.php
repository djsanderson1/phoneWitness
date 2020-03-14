 <!doctype html>
<?php
require_once('authenticate.php');
require_once('functions/publishers/getPublishers.php');
?>

<html>
  <head>
    <title>Admin</title>
    <?php include 'style.php'; ?>

  </head>
  <body onload="exportForm.howMany.focus();">
    <?php include 'navbar.php'; ?>
    <h1>Export Addresses for territory number: <?php
    if(isset($_GET['territory_id'])) {
      $territory_id = $_GET['territory_id'];
      require_once('mysqlConnect.php');
      $res=$con->query("
      SELECT territory_number, territoryImageUrl
        FROM territories
       WHERE territory_id = $territory_id");
      while ($row = $res->fetch_assoc()) {
        global $territory_number;
        $territory_number = $row["territory_number"];
        echo $territory_number;
        if($row['territoryImageUrl'] == "") {
          echo '<h3>No image</h3>';
        }
        else {
          echo '<br><a href="' . $row['territoryImageUrl'] . '" target="_blank"><img src="' . $row['territoryImageUrl'] . '" class="territoryImage"></a>';
        }
      }
    }
    else {
    ?><form action="" method="get"><select name="territory_id"><?php
      require_once('mysqlConnect.php');
      $res=$con->query("
      SELECT territory_queue.territory_id, territory_queue.order_number, territories.territory_number territory_number,
        (select count(*) from residents
        where
        ((address_export_id IS NULL OR address_export_id = 0) AND (status_id2 <> 3 OR status_id2 IS NULL))
                    AND (
                      number_of_tries >= 3
                      OR phone_number IS NULL
                      OR phone_number = '')
                    AND territory_id = territory_queue.territory_id) AS available_exports

        FROM territory_queue
        LEFT JOIN territories USING(territory_id)

       WHERE territory_queue.order_number > 0
       ORDER BY CAST(territory_number AS UNSIGNED)
       ");
      while ($row = $res->fetch_assoc()) {
        $territory_id = $row['territory_id'];
        $territory_number = $row['territory_number'];
        $order_number = $row['order_number'];
        $available_exports = $row['available_exports'];
        echo '<option value="'.$territory_id.'">Territory #'.$territory_number.' ('.$available_exports.' Available Addresses)</option>';
      } ?>
    </select><button type="submit">Select for Export</button></form></h1>
    <?php
    exit;
    }
    ?></h1>
    <p>Select how many addresses you want to export.</p>
    Available to export:
      <?php
      include 'mysqlConnect.php';
      $qryFilterMostly = "((address_export_id IS NULL OR address_export_id = 0) AND (status_id2 <> 3 OR status_id2 IS NULL))
                    AND (
                      number_of_tries >= 3
                      OR phone_number IS NULL
                      OR phone_number = '')
                    AND territory_id = ";
      if(isset($_GET['territory_id'])) {
        $territory_id = $_GET['territory_id'];
        $qryFilter = $qryFilterMostly . $territory_id;
      //  echo "<br>" . $qryFilter . "<br>";
        $res=$con->query("
        SELECT COUNT(*) AS total_addresses
        FROM residents
        WHERE" . $qryFilter
            );
            global $totalAddresses;
        while ($row = $res->fetch_assoc()) {
          echo $row["total_addresses"];
          global $totalAddresses;
          $totalAddresses = $row["total_addresses"];
        }

      //  echo "<br>" . $qryFilter;
      }
      if(isset($_POST['howMany'])) {
        $territory_id = $_POST['territory_id'];
        $qryFilter = $qryFilterMostly . $territory_id;
        $howMany = $_POST['howMany'];
        require_once('functions/publishers/getPublishers.php');
        if(isset($_POST['publisher_id'])) {
          $publisher_id = $_POST['publisher_id'];
        } else {
          $publisher_id = getPublisherFromUser();
        }
        $sqlPublisherName = "
          SELECT first_name, last_name
          FROM publishers
          WHERE publisher_id = $publisher_id";
        $res=$con->query($sqlPublisherName);
        while ($row = $res->fetch_assoc()) {
          global $strPublisherFirstName, $strPublisherLastName;
          $strPublisherFirstName = $row['first_name'];
          $strPublisherLastName = $row['last_name'];
        }
        $todaysDate = date("m-d-Y H.i.s");

        if(!$howMany) {
          $howMany = 0;
        }

        if($howMany > 0) {
          $addressList = "";
          $res=$con->query("
          SELECT *
          FROM residents
          LEFT JOIN territories USING(territory_id)
          WHERE" . $qryFilter . "
          LIMIT " . $howMany);
          echo $_POST['fileType'];
          switch($_POST['fileType']) {

            case 'csv':
            while ($row = $res->fetch_assoc()) {
              if($row["status_id2"]==6) {
                $daySleeper = ",Day Sleeper";
              } else {
                $daySleeper = "";
              }
              if($addressList == "") {
                $addressList = $row["name"] . "," . $row["address"] . $daySleeper . "\r\n";
              }
              else {
                $addressList = $addressList . $row["name"] . "," . $row["address"] . $daySleeper . "\r\n";
              }
              global $territory_number;
              $territory_number = $row['territory_number'];
            }
            $exportPath = $_SERVER['DOCUMENT_ROOT'] . "/exports/";
            $exportFileName = "Territory Number " . $territory_number . " - " . $strPublisherFirstName . " " . $strPublisherLastName . " - " . $todaysDate . ".csv";
            $myfile = fopen($exportPath . $exportFileName, "w") or die("Unable to open file!");
            fwrite($myfile, $addressList);
            fclose($myfile);
            global $filePath;
            $filePath = "/exports/".$exportFileName;
              break;
            case 'pdf':
            require('fpdf181/fpdf.php');

            $pdf = new FPDF();
            $pdf->AddPage('P','Letter');

            // headers
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(100,10,'Territory #'.$territory_number.' Checked Out to: '.$strPublisherFirstName.' '.$strPublisherLastName.' '.date("m/d/Y"));
            $pdf->ln();
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(75,5,'Name');
            $pdf->Cell(500,5,'Address');
            $pdf->ln();
            $pdf->SetFont('Arial','',11);

            $paginationCounter = 0;
            while ($row = $res->fetch_assoc()) {
              $paginationCounter++;
              if($paginationCounter > 40) {
                // creates new page
                $pdf->AddPage('P','Letter');

                // headers
                $pdf->SetFont('Arial','B',14);
                $pdf->Cell(100,10,'Territory #'.$territory_number.' Checked Out to: '.$strPublisherFirstName.' '.$strPublisherLastName.' '.date("m/d/Y"));
                $pdf->ln();
                $pdf->SetFont('Arial','B',11);
                $pdf->Cell(75,5,'Name');
                $pdf->Cell(500,5,'Address');
                $pdf->ln();
                $pdf->SetFont('Arial','',11);

                // reset counter
                $paginationCounter = 1;
              }
              $daySleeper = "";
              if($row["status_id2"]==6) {
                $daySleeper = "Day Sleeper";
              }
              $name = $row["name"];
              $address = $row["address"];
              global $territory_number;
              $territory_number = $row['territory_number'];

              // add cells for each line
              $pdf->Cell(75,5.8,$name);
              $pdf->Cell(500,5.8,$address);
              $pdf->ln();
            }
            $exportPath = $_SERVER['DOCUMENT_ROOT'] . "/exports/";
            $exportFileName = "Territory Number " . $territory_number . " - " . $strPublisherFirstName . " " . $strPublisherLastName . " - " . $todaysDate . ".pdf";
            $pdf->Output('F',$exportPath.$exportFileName);
            global $filePath;
            $filePath = '/exports/'.$exportFileName;
          }

          $con->query("
            INSERT INTO
            address_exports
            (
              export_date,
              publisher_id,
              file_path
              )

              values (
                now(),
                $publisher_id,
                '$filePath'
                )
          ");
          $con->query("
            UPDATE residents
            SET address_export_id = last_insert_id(),
            last_called_date = date(now())
            WHERE " . $qryFilter . "
            LIMIT " . $howMany
          );
          echo '<meta http-equiv="refresh" content="1; url=/exports/'.$exportFileName.'">';
      }


    }
      ?>
    <form action="export_addresses.php?territory_id=<?php echo $territory_id; ?>" name="exportForm" method="POST" onsubmit="return howManyTest();">
      <input type="hidden" name="territory_id" value="<?php echo $territory_id; ?>">
      <table class="frm2Col">
        <?php
        if($_SESSION["userTypeID"] == 1) {
        ?>
        <tr>
          <td><label for="fileType">Publisher to Check Out to:</label></td>
          <td>
            <?php activePublishersDropDown(); ?>
          </td>
        </tr>
      <?php } ?>
        <tr>
          <td><label for="howMany">How Many Addresses to Export?:</label></td>
          <td><input type="number" name="howMany" id="howMany" onchange="return howManyTest();"></td>
        </tr>
        <tr>
          <td><label for="fileType">Export File Type:</label></td>
          <td>
            <select name="fileType" id="fileType">
              <option value="pdf">PDF(Recommended)</option>
              <option value="csv">CSV</option>
            </select>
          </td>
        </tr>
        <tr>
          <td><button type="submit">Export Now!</button></td>
          <td></td>
        </tr>
      </table>
    </form>
    <script>
    function howManyTest() {
      var howMany = document.getElementById("howMany");
      var maxNum = <?php
      $publisher_id = getPublisherFromUser();
      $remainingExports = getRemainingWeeklyExports($publisher_id);
      if($remainingExports >= $totalAddresses) {
        echo $totalAddresses;
      } else {
        echo $remainingExports;
      }
      ?>;
      var publisherID = <?php echo $publisher_id; ?>;
      var lastSaturday = <?php echo getLastSaturday(); ?>;
      var thisWeeksExports = <?php echo getThisWeeksExports($publisher_id); ?>;
      if(howMany.value > 0 && howMany.value <= maxNum) {
        return publisherTest();
        return true;
      } else {
        alert("Invalid number to export or you are over your limit for the week");
        return false;
      }
    }
    function publisherTest() {
      var publisherDropDown = document.getElementById("publisher_id");
        if(publisherDropDown.value == "0") {
          alert("Please select a publisher to check out to!");
          return false;
      }
    }
    </script>
  </body>

</html>
