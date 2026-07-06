<div class="container-fluid text-center">
    <h2>Segnalazioni</h2>
    <section>
        <h3><a href="report.php?action=send-report">Fai una segnalazione</a></h3>
    </section>
    <section>
        <h3>Filtri</h3>

    </section>
    <div class="row justify-content-center gap-2">
        <?php
        foreach ($templateParams["reports"] as $report):
            $place = $dbh->getPlaceFromID($report["PlaceID"]);
            ?>
            <div class="border-mode-text border-solid rounded mode-gray p-2 col-10 col-md-5 col-xl-3">
                <h4 class="border-b border-mode-text rounded"><?php echo $report["Type"]; ?></h4>
                <p><strong>Luogo</strong>: <?php echo $place["Name"]; ?></p>
                <p><strong>Stato</strong>: <?php echo $report["State"]; ?></p>
                <p><strong>Data Inserimento</strong>: <?php echo $report["CreationDate"]; ?></p>
                <p><strong>Descrizione</strong>: <?php echo $report["Description"]; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>