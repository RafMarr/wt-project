<div class="container-fluid row text-center justify-content-center m-0 p-0">
    <div class="col-10 col-md-8">

        <h1 class="mb-4">Informazioni sui corsi</h1>

        <?php if (isset($templateParams["admin"])): ?>
          <div class="row justify-content-center mb-4">
            <label for="degree-select" class="col-4 form-label my-2">Corso di Laurea: </label>
            <select id="degree-select" class="form-select w-50">
              <option value="0">Scegli...</option>
                <optgroup label="Triennale">
                    <?php foreach ($templateParams["corsi-laurea"] as $corso): 
                      if ($corso["Type"] === "Laurea triennale"): ?>
                      <option value="<?php echo $corso["DegreeCourseID"]; ?>"><?php echo $corso["Name"]; ?></option>
                    <?php endif;
                    endforeach; ?>
                </optgroup>
                <optgroup label="Magistrale">
                    <?php foreach ($templateParams["corsi-laurea"] as $corso): 
                      if ($corso["Type"] === "Laurea magistrale"): ?>
                      <option value="<?php echo $corso["DegreeCourseID"]; ?>"><?php echo $corso["Name"]; ?></option>
                    <?php endif;
                    endforeach; ?>
                </optgroup>
            </select>
          </div>
        <?php endif; ?>

        <div id="small-media-container" class="d-md-none">
          <?php
          $templateParams["section"]["id"] = "accordionPrimoAnno";
          $templateParams["section"]["h2"] = "Primo anno";
          if (isset($templateParams["admin"])) $templateParams["section"]["h2"] .= " triennale";
          $templateParams["section"]["target"] = "collapseOne";
          $templateParams["section"]["year"] = 1;
          $templateParams["section"]["degree-type"] = "Laurea triennale";
          require("corsi-section-small.php");
          
          $templateParams["section"]["id"] = "accordionSecondoAnno";
          $templateParams["section"]["h2"] = "Secondo anno";
          if (isset($templateParams["admin"])) $templateParams["section"]["h2"] .= " triennale";
          $templateParams["section"]["target"] = "collapseTwo";
          $templateParams["section"]["year"] = 2;
          $templateParams["section"]["degree-type"] = "Laurea triennale";
          require("corsi-section-small.php");
          
          if (isset($templateParams["admin"]) || $templateParams["degree-type"] === "Laurea triennale") {
            $templateParams["section"]["id"] = "accordionTerzoAnno";
            $templateParams["section"]["h2"] = "Terzo anno";
            if (isset($templateParams["admin"])) $templateParams["section"]["h2"] .= " triennale";
            $templateParams["section"]["target"] = "collapseThree";
            $templateParams["section"]["year"] = 3;
            $templateParams["section"]["degree-type"] = "Laurea triennale";
            require("corsi-section-small.php");
          }
          ?>
          <?php
          if (isset($templateParams["admin"])) {
            $templateParams["section"]["id"] = "accordionQuartoAnno";
            $templateParams["section"]["h2"] = "Primo anno magistrale";
            $templateParams["section"]["target"] = "collapseFour";
            $templateParams["section"]["year"] = 1;
            $templateParams["section"]["degree-type"] = "Laurea magistrale";
            require("corsi-section-small.php");

            $templateParams["section"]["id"] = "accordionQuintoAnno";
            $templateParams["section"]["h2"] = "Secondo anno magistrale";
            $templateParams["section"]["target"] = "collapseFive";
            $templateParams["section"]["year"] = 2;
            $templateParams["section"]["degree-type"] = "Laurea magistrale";
            require("corsi-section-small.php");
          }
          ?>
        </div>

        <!-- Versione Desktop senza accordion -->

        <div id="medium-media-container" class="d-none d-md-block">
          <?php
          $templateParams["section"]["h2"] = "Primo anno";
          if (isset($templateParams["admin"])) $templateParams["section"]["h2"] .= " triennale";
          $templateParams["section"]["year"] = 1;
          $templateParams["section"]["degree-type"] = "Laurea triennale";
          require("corsi-section-medium.php");

          $templateParams["section"]["h2"] = "Secondo anno";
          if (isset($templateParams["admin"])) $templateParams["section"]["h2"] .= " triennale";
          $templateParams["section"]["year"] = 2;
          $templateParams["section"]["degree-type"] = "Laurea triennale";
          require("corsi-section-medium.php");

          if (isset($templateParams["admin"]) || $templateParams["degree-type"] === "Laurea triennale") {
            $templateParams["section"]["h2"] = "Terzo anno";
            if (isset($templateParams["admin"])) $templateParams["section"]["h2"] .= " triennale";
            $templateParams["section"]["year"] = 3;
            $templateParams["section"]["degree-type"] = "Laurea triennale";
            require("corsi-section-medium.php");
          }
          ?>
          <?php
          if (isset($templateParams["admin"])) {
            $templateParams["section"]["h2"] = "Primo anno magistrale";
            $templateParams["section"]["year"] = 1;
            $templateParams["section"]["degree-type"] = "Laurea magistrale";
            require("corsi-section-medium.php");

            $templateParams["section"]["h2"] = "Secondo anno magistrale";
            $templateParams["section"]["year"] = 2;
            $templateParams["section"]["degree-type"] = "Laurea magistrale";
            require("corsi-section-medium.php");
          }
          ?>
        </div>
    </div>
</div>