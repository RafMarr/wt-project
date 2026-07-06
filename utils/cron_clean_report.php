<?php
// cron job setup per la pulizia delle segnalazioni Risolte.
// Utilizzo di flock suggerito da Jack: https://stackoverflow.com/a/10552054
try {
    $now = time();
    $lockFile = __DIR__ . DIRECTORY_SEPARATOR . 'report_lock';

    $f = fopen($lockFile, 'c+'); 
    
    if (flock($f, LOCK_EX | LOCK_NB)) {
        
        $lastRun = (int)fread($f, 100);
        
        if ($now - $lastRun > 3600) {
            
            $dbh->deleteExpiredReports();
            
            ftruncate($f, 0);
            rewind($f);
            fwrite($f, (string)$now);
        }
        
        flock($f, LOCK_UN);
    }
    fclose($f);
} catch (Exception $e) {
}
?>