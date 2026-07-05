<div class="container-fluid text-center">
    <h2>Segnalazioni</h2>
    <?php if (isset($templateParams["admin"])): ?>
    <section>
        <h3><a href="report.php?action=report-admin">Gestisci Segnalazioni</a></h3>
    </section>
    <?php else: ?>
    <section>
        <h3><a href="report.php?action=send-report">Fai una segnalazione</a></h3>
    </section>
    <?php endif; ?>
    <section>
        <h3>Filtri</h3>

    </section>
    <div>
        <?php
        foreach ($templateParams["reports"] as $report):
            $place = $dbh->getPlaceFromID($report["PlaceID"]);
            ?>
            <div>
                <h4><?php echo $report["Type"]; ?></h4>
                <p><strong>Luogo</strong>: <?php echo $place["Name"]; ?></p>
                <p><strong>Stato</strong>: <?php echo $report["State"]; ?></p>
                <p><strong>Data Inserimento</strong>: <?php echo $report["CreationDate"]; ?></p>
                <p><strong>Descrizione</strong>: <?php echo $report["Description"]; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>