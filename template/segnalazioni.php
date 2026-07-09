<div class="container-fluid text-center">
    <h1>Segnalazioni</h1>
    <section>
        <h2><a href="report.php?action=send-report">Fai una segnalazione</a></h2>
    </section>
    <section>
        <h2>Filtri</h2>

    </section>
    <div class="row justify-content-center gap-2">
        <?php
        foreach ($templateParams["reports"] as $report):
            $place = $dbh->getPlaceFromID($report["PlaceID"]);
            ?>
            <div class="border-mode-gray border-2 border-solid rounded mode-gray p-2 col-10 col-md-5 col-xl-3">
                <h3 class="border-b-2 border-mode-gray rounded"><?php echo $report["Type"]; ?></h3>
                <p><strong>Luogo</strong>: <?php echo $place["Name"]; ?></p>
                <p><strong>Stato</strong>: <?php echo $report["State"]; ?></p>
                <p><strong>Data Inserimento</strong>: <?php echo $report["CreationDate"]; ?></p>
                <p><strong>Descrizione</strong>: <?php echo $report["Description"]; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>