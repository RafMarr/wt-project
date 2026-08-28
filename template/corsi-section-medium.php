<div class="mb-3 p-2 border-b-2 border-mode-gray">
    <h2><?php echo $templateParams["section"]["h2"]; ?></h2>
    <div class="row justify-content-center">
        <section class="col-6 p-2 px-4 text-start">
            <h3>Primo Semestre</h3>
            <ul class="list-style-none px-2 m-0">
                <?php foreach($templateParams["lista-corsi"] as $corso): 
                if ($corso["Year"] === $templateParams["section"]["year"] && $corso["Semester"] === 1 && (!isset($templateParams["admin"]) || $corso["Type"] === $templateParams["section"]["degree-type"])): ?>
                    <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                <?php endif;
                endforeach; ?>
            </ul>
        </section>
        <section class="col-6 p-2 px-4 text-start">
            <h3>Secondo Semestre</h3>
            <ul class="list-style-none px-2 m-0">
                <?php foreach($templateParams["lista-corsi"] as $corso): 
                if ($corso["Year"] === $templateParams["section"]["year"] && $corso["Semester"] === 2 && (!isset($templateParams["admin"]) || $corso["Type"] === $templateParams["section"]["degree-type"])): ?>
                    <li class="my-2"><a class="mode-text" href="courses.php?courseID=<?php echo $corso["CourseID"]; ?>"><?php echo $corso["CourseID"] . " - " . $corso["Name"]; ?></a></li>
                <?php endif;
                endforeach; ?>
            </ul>
        </section>
    </div>
    </div>