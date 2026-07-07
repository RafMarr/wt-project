<div class="container-fluid text-center">
    <h2>Orario delle Lezioni</h2>
    <div class="row justify-content-center gap-2">
        <div class="row justify-content-center col-10 col-md-4">
            <label for="data-filtro" class="form-label col-3 my-2">Data</label>
            <input id="data-filtro" type="date" class="form-control w-50" value="<?php echo $currentDate; ?>" />
        </div>
        <div class="row justify-content-center col-10 col-md-4">
            <label for="anno-filtro" class="form-label col-3 my-2">Anno</label>
            <select id="anno-filtro" type="date" class="form-select w-50">
                <?php if (isset($templateParams["admin"])): ?>
                <optgroup label="Triennale">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </optgroup>
                <optgroup label="Magistrale">
                    <option value="4">1</option>
                    <option value="5">2</option>
                </optgroup>
                <?php else: ?>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <?php if ($dbh->getDegreeTypeFromEmail($_SESSION["idutente"])["Type"]): ?>
                        <option value="3">3</option>
                    <?php endif;
                    endif; ?>
            </select>
        </div>
    </div>
    <div id="lesson-container" class="row justify-content-center gap-2 mt-2">
        <?php foreach ($templateParams["lessons"] as $lesson): ?>
            <div class="row justify-content-center border-mode-text border-solid rounded mode-gray lesson-card-md col-10 p-2">
                <div class="row justify-content-between justify-content-md-start border-b border-mode-text border-md-0 col-12">
                    <div class="row col-3 align-items-center row-gap-2 m-0">
                        <div class="d-none d-md-inline col-2 p-0" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            </svg>
                        </div>
                        <p class="col-12 col-md-5 p-0 m-0"><?php echo substr($lesson["StartTime"], 5); ?></p>
                        <p class="col-12 col-md-5 p-0 m-0"><?php echo substr($lesson["EndTime"], 5); ?></p>
                    </div>
                    <div class="col-9 d-flex align-items-center justify-content-center justify-content-md-start">
                        <h3 class="fs-4 my-1"><a class="mode-text" href="#"><?php echo $lesson["CourseName"]; ?></a></h3>
                    </div>
                </div>
                <div class="row align-items-center col-12 my-1 justify-content-md-start">
                    <p class="col-12 col-md-3 text-md-start m-0"><strong>Aula</strong>: <?php echo $lesson["PlaceName"]; ?></p>
                    <p class="col-12 col-md-9 text-md-start m-0"><strong>Docente</strong>: <?php echo $lesson["Date"]; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>