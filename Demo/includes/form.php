<!-- include the form -->
    <div class="form-container">
        <form id="addCar" class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <h1>Add Car</h1>
            <div class="form-field">
                <label for="make">Make:</label>
                <select id="make" name="make" size="1" value="" required onchange="resetCarModelOptions()" autocomplete="off">
                    <option selected class="selectMake" value="">Select an option...</option>
                    <option value="Ford" onclick="showCarModel(fordList, toyotaList, seatList, addModel)" <?php if(strtolower($make) == 'ford') {echo 'selected="selected"'; } ?>>Ford</option>
                    <option value="Toyota" onclick="showCarModel(toyotaList, fordList, seatList, addModel)" <?php if(strtolower($make) == 'toyota') {echo 'selected="selected"'; } ?>>Toyota</option>
                    <option value="Seat" onclick="showCarModel(seatList, fordList, toyotaList, addModel)" <?php if(strtolower($make) == 'seat') {echo 'selected="selected"'; } ?>>Seat</option>
                </select>
                <small><?php if($makeErrorMessage !== "") {echo $makeErrorMessage; } ?></small>
            </div>

            <div class="form-field">
                <label for="model">Model</label>
                <select id="model" name="model" size="1" required autocomplete="off">
                    <option selected value="">Select an option...</option>
                    <option class="ford hide" value="Focus" <?php if(strtolower($model) == 'focus') {echo 'selected="selected"'; } ?>>Focus</option>
                    <option class="ford hide" value="Fiesta" <?php if(strtolower($model) == 'fiesta') {echo 'selected="selected"'; } ?>>Fiesta</option>
                    <option class="ford hide" value="Mondeo" <?php if(strtolower($model) == 'mondeo') {echo 'selected="selected"'; } ?>>Mondeo</option>
                    <option class="toyota hide" value="Corolla" <?php if(strtolower($model) == 'corolla') {echo 'selected="selected"'; } ?>>Corolla</option>
                    <option class="toyota hide" value="Yaris" <?php if(strtolower($model) == 'yaris') {echo 'selected="selected"'; } ?>>Yaris</option>
                    <option class="toyota hide" value="Prius" <?php if(strtolower($model) == 'prius') {echo 'selected="selected"'; } ?>>Prius</option>
                    <option class="seat hide" value="Leon" <?php if(strtolower($model) == 'leon') {echo 'selected="selected"'; } ?>>Leon</option>
                    <option class="seat hide" value="Cordoba" <?php if(strtolower($model) == 'cordoba') {echo 'selected="selected"'; } ?>>Cordoba</option>
                    <option class="seat hide" value="Ibiza" <?php if(strtolower($model) == 'ibiza') {echo 'selected="selected"'; } ?>>Ibiza</option>
                </select>
                <small><?php if($modelErrorMessage !== "") {echo $modelErrorMessage; } ?></small>
            </div>

            <div class="form-field">
                <label for="vin">Vehicle Identification Number:</label>
                <input type="text" name="vin" id="vin" autocomplete="off" placeholder="12KsnKSLEvmsnkx319" required minlength="17" maxlength="17" value="<?php if($vin !== "") {echo $vin;}?>" <?php if($_SERVER['PHP_SELF'] === '/Demo/update.php') {echo 'readonly'; } ?>>
                <small><?php if($vinErrorMessage !== "") {echo $vinErrorMessage; } ?> <?php if($_SERVER['PHP_SELF'] === '/Demo/update.php') {echo 'You cannot change the VIN'; } ?></small>
            </div>


            <div class="form-field">
                <label for="yearManufacture">Year of Manufacture:</label>
                <input type="text" name="yearManufacture" id="yearManufacture" placeholder="Between 2013 and now..." autocomplete="off" value ="<?php if($yearManufacture !== "") {echo $yearManufacture;} ?>">
                <small><?php if($yearManufactureErrorMessage !== "") {echo $yearManufactureErrorMessage; } ?></small>
            </div>

            <div class="form-field">
                <label for="engine">Engine Size:</label>
                <select id="engine" name="engine" autocomplete="off">
                    <option selected>Select an option...</option>
                    <option value="1.5" <?php if($fuel === '1.5') {echo 'selected="selected"'; } ?>>1.5L</option>
                    <option value="1.6" <?php if($fuel === '1.6') {echo 'selected="selected"'; } ?>>1.6L</option>
                    <option value="1.7" <?php if($fuel === '1.7') {echo 'selected="selected"'; } ?>>1.7L</option>
                    <option value="1.8" <?php if($fuel === '1.8') {echo 'selected="selected"'; } ?>>1.8L</option>
                    <option value="2.0" <?php if($fuel === '2.0') {echo 'selected="selected"'; } ?>>2.0L</option>
                    <option value="2.2" <?php if($fuel === '2.2') {echo 'selected="selected"'; } ?>>2.2L</option>
                    <option value="2.3" <?php if($fuel === '2.3') {echo 'selected="selected"'; } ?>>2.3L</option>
                    <option value="2.5" <?php if($fuel === '2.5') {echo 'selected="selected"'; } ?>>2.5L</option>
                    <option value="2.6" <?php if($fuel === '2.6') {echo 'selected="selected"'; } ?>>2.6L</option>
                    <option value="2.8" <?php if($fuel === '2.8') {echo 'selected="selected"'; } ?>>2.8L</option>
                    <option value="3.0" <?php if($fuel === '3.0') {echo 'selected="selected"'; } ?>>3.0L</option>
                </select>
                <small><?php if($engineErrorMessage !== "") {echo $engineErrorMessage; } ?></small>
            </div>

            <div class="form-field">
                <p class="form-field-p">Transmission:</p>
                <div class="radio" id="transmission-radio">
                    <label for="manual">
                        <input type="radio" name="transmission" id="manual" value="manual" <?php if($transmission === "manual") {echo 'checked'; } ?>>Manual
                    </label>
                    <label for="automatic">
                        <input type="radio" name="transmission" id="automatic" value="automatic" <?php if($transmission === "automatic") {echo 'checked'; } ?>>Automatic
                    </label>
                    <small><?php if($transmissionErrorMessage !== "") {echo $transmissionErrorMessage; } ?></small>
                </div>
            </div>

            <div class="form-field">
                <label for="seats">Number of Seats:</label>
                <input type="number" name="seats" id="seats" placeholder="5" autocomplete="off" required value="<?php if($seats !== "") {echo $seats;}?>">
                <small><?php if($seatsErrorMessage !== "") {echo $seatsErrorMessage; } ?></small>
            </div>


            <div class="form-field">
                <label for="doors">Number of Doors:</label>
                <input type="number" name="doors" id="doors" placeholder="5" autocomplete="off" required value="<?php if($doors !== "") {echo $doors;}?>">
                <small><?php if($doorsErrorMessage !== "") {echo $doorsErrorMessage; } ?></small>
            </div>


            <div class="form-field">
                <p class="form-field-p">Fuel Type:</p>
                <div class="radio">
                    <label for="petrol">
                        <input type="radio" name="fuel" id="petrol" value="petrol" <?php if($fuel === "petrol") {echo 'checked'; } ?>>Petrol
                    </label>
                    <label for="diesel">
                        <input type="radio" name="fuel" id="diesel" value="diesel" <?php if($fuel === "diesel") {echo 'checked'; } ?>>Diesel
                    </label>
                    <small><?php if($fuelErrorMessage !== "") {echo $fuelErrorMessage; } ?></small>
                </div>
            </div>


            <div class="form-field">
                <label for="colour">Colour:</label>
                <input type="text" name="colour" id="colour" placeholder="green" autocomplete="off" required value="<?php if($colour !== "") {echo $colour;}?>">
                <small><?php if($colourErrorMessage !== "") {echo $colourErrorMessage; } ?></small>
            </div>


            <div class="form-field">
                <label for="reg">Registration Number:</label>
                <input type="text" name="reg" id="reg" placeholder="131d2019" autocomplete="off" required value="<?php if($reg !== "") {echo $reg;}?>">
                <small><?php if($regErrorMessage !== "") {echo $regErrorMessage; } ?></small>
            </div>


            <div class="form-field">
                <label for="date">Date of First Registration:</label>
                <input type="date" name="date" id="date" autocomplete="off" required value="<?php if($originalReg !== "") {echo $originalReg;}?>">
                <small><?php if($originalRegErrorMessage !== "") {echo $originalRegErrorMessage; } ?></small>
            </div>



            <div id="signUpButton" class="form-field">
                <input type="submit" value="Submit" name="submit">
            </div>
        </form>
    </div>

