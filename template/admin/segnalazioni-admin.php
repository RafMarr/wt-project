<div class="container-fluid text-center">
    <h2>Gestisci Segnalazioni</h2>
    <section>
        <h3>Filtri</h3>

    </section>
    <div>
        <?php
        foreach ($templateParams["reports"] as $report):
            if ($report["TeachingPlaceID"] != NULL) {
                $report["place"] = $dbh->getTeachingPlaceType($report["TeachingPlaceID"])["Type"]." ".$report["TeachingPlaceID"];
            }
            else if ($report["BathroomID"] != NULL) {
                $bathroom = $dbh->getBathroom($report["BathroomID"]);
                $report["place"] = "Bagno {$report["BathroomID"]} al piano {$bathroom["Floor"]} e blocco {$bathroom["Block"]}";
            }
            else if ($report["CorridorFloor"] != NULL && $report["CorridorBlock"] != NULL) {
                $report["place"] = "Corridoio al piano {$report["CorridorFloor"]} e blocco {$report["CorridorBlock"]}";
            }
            else if ($report["BikeParkingFloor"] != NULL) {
                $report["place"] = "Parcheggio delle biciclette al piano {$report["BikeParkingFloor"]}";
            }
            ?>
            <div>
                <h4><?php echo $report["Type"]; ?></h4>
                <p><strong>Luogo</strong>: <?php echo $report["place"]; ?></p>
                <p><strong>Stato</strong>: <?php echo $report["State"]; ?></p>
                <p><strong>Data Inserimento</strong>: <?php echo $report["CreationDate"]; ?></p>
                <p><strong>Descrizione</strong>: <?php echo $report["Description"]; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>