<div class="container-fluid text-center">
    <h2>Orario delle Lezioni</h2>
    <div class="row justify-content-center gap-2">
        <div class="row justify-content-center col-8 col-md-6 mx-1">
            <label for="data-filtro" class="form-label col-3 my-2">Data</label>
            <input id="data-filtro" type="date" class="form-control w-50" value="<?php echo $currentDate; ?>" />
        </div>
        <div class="row justify-content-center col-8 col-md-6 mx-1">
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
            <div class="row justify-content-center border-mode-text border-solid rounded mode-gray col-10 col-md-5 col-xl-3 m-2">
                <div class="row justify-content-between border-b border-mode-text col-12">
                    <div class="row col-3 align-items-center row-gap-2">
                        <p class="col-12 p-0 m-0"><?php echo substr($lesson["StartTime"], 5); ?></p>
                        <p class="col-12 p-0 m-0"><?php echo substr($lesson["EndTime"], 5); ?></p>
                    </div>
                    <div class="col-9 d-flex align-items-center justify-content-center">
                        <h3 class="fs-4 my-1"><a class="mode-text" href="#"><?php echo $lesson["CourseName"]; ?></a></h3>
                    </div>
                </div>
                <div class="row align-items-center col-12 my-1">
                    <p class="col-12 m-0"><strong>Aula</strong>: <?php echo $lesson["PlaceName"]; ?></p>
                    <p class="col-12 m-0"><strong>Docente</strong>: <?php echo $lesson["Date"]; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>