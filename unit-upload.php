<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Unit Uploader';


$figureName = $_POST["figureName"];

$factionName = $_POST["factionName"];
$traitName = $_POST["traitName"];
$rankName = $_POST["rankName"];
$weaponName = $_POST["weaponName"];
$weaponTrait = $_POST["weaponTrait"];



if(!empty($figureName))
{
	//check to see if faction already exists
	$query = $db->prepare("SELECT * FROM Figures WHERE Name=:name");
	$query->execute(array(':name' => $figureName));

	if($query->rowCount() <= 0)
	{
		$figureAlias = $_POST['figureAlias'];
		$repCost = $_POST['reputationCost'];
		$fundingCost = $_POST['fundingCost'];
		$willpower = $_POST['willpower'];
		$strength = $_POST['strength'];
		$movement = $_POST['movement'];
		$attack = $_POST['attack'];
		$defense = $_POST['defense'];
		$endurance = $_POST['endurance'];
		$special = $_POST['special'];
		$specialTraits = $_POST['specialTraits'];

		if(empty($figureAlias)){$errorMessages[] = "Empty alias";}
		if(empty($repCost)){$errorMessages[] = "Empty repCost";}
		if(empty($fundingCost)){$errorMessages[] = "Empty fundingCost";}
		if(empty($willpower)){$errorMessages[] = "Empty willpower";}
		if(empty($strength)){$errorMessages[] = "Empty strength";}
		if(empty($movement)){$errorMessages[] = "Empty movement";}
		if(empty($attack)){$errorMessages[] = "Empty attack";}
		if(empty($defense)){$errorMessages[] = "Empty defense";}
		if(empty($endurance)){$errorMessages[] = "Empty endurance";}
		if(empty($special)){$errorMessages[] = "Empty special";}
		if(empty($specialTraits)){$errorMessages[] = "Empty specialTraits";}
		if(empty($_POST['factions'])){$errorMessages[] = "Empty faction!";}

		if(empty($errorMessages))
		{
			$query = $db->prepare("INSERT INTO Figures(Name,Alias,ReputationCost,FundingCost,SpecialTraits,Willpower,Strength,Movement,Attack,Defense,Endurance,Special) VALUES(:name,:alias,:rep,:fund,:traits,:will,:str,:move,:att,:def,:en,:spec)");
			$query->execute(array(
			 	':name' => $figureName,
			 	':alias' => $figureAlias,
			 	':rep' => $repCost,
			 	':fund' => $fundingCost,
			 	':traits' => $specialTraits,
			 	':will' => $willpower,
			 	':str' => $strength,
			 	':move' => $movement,
			 	':att' => $attack,
			 	':def' => $defense,
			 	':en' => $endurance,
			 	':spec' => $special,
			));	
			
			if($query->rowCount() >= 1)
			{
				$figureRow = $db->lastInsertId();

				//add faction
				foreach($_POST["factions"] as $faction)
				{
					$query = $db->prepare("INSERT INTO Figure_Factions(Figure,Faction) VALUES(:fig,:fac)");
					$query->execute(array(':fig' => $figureRow,':fac' => $faction));
				}
				foreach($_POST["ranks"] as $rank)
				{
					$query = $db->prepare("INSERT INTO Figure_Ranks(Figure,Rank) VALUES(:x,:y)");
					$query->execute(array(':x' => $figureRow,':y' => $rank));
				}
				foreach($_POST["traits"] as $trait)
				{
					$query = $db->prepare("INSERT INTO Figure_Traits(Figure,Trait) VALUES(:x,:y)");
					$query->execute(array(':x' => $figureRow,':y' => $trait));
				}
				foreach($_POST["weapons"] as $trait)
				{
					$query = $db->prepare("INSERT INTO Figure_Weapons(Figure,Weapon) VALUES(:x,:y)");
					$query->execute(array(':x' => $figureRow,':y' => $trait));
				}
				foreach($_POST["hatesFactions"] as $trait)
				{
					$query = $db->prepare("INSERT INTO Figure_HatesFaction(FigureID,FactionID) VALUES(:x,:y)");
					$query->execute(array(':x' => $figureRow,':y' => $trait));
				}
				foreach($_POST["hatesFigures"] as $trait)
				{
					$query = $db->prepare("INSERT INTO Figure_HatesFigure(Hater,Hated) VALUES(:x,:y)");
					$query->execute(array(':x' => $figureRow,':y' => $trait));
				}
				foreach($_POST["affinitys"] as $trait)
				{
					$query = $db->prepare("INSERT INTO Figure_Affinitys(LoverID,LovedID) VALUES(:x,:y)");
					$query->execute(array(':x' => $figureRow,':y' => $trait));
				}

				$successMessage = "Figure Added Succesfully";

			}
			else
			{
				$errorMessages[] = "Figure not added. Idk why";
			}
		}

			
		
	}
	else
	{
		$errorMessages[] = "Figure already exist you dumbass";
	}
	//$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
elseif(!empty($factionName))//add new faction
{
	//check to see if faction already exists
	$query = $db->prepare("SELECT * FROM Faction WHERE Name=:name");
	$query->execute(array(':name' => $factionName));

	if($query->rowCount() <= 0)
	{
		$query = $db->prepare("INSERT INTO Faction(Name) VALUES(:name)");
		$query->execute(array(':name' => $factionName));	
		
		if($query->rowCount() >= 1)
		{
			$successMessage = "Faction Added Succesfully";
		}
		else
		{
			$errorMessages[] = "Faction not added. Idk why";
		}
		
	}
	else
	{
		$errorMessages[] = "Faction already exist you dumbass";
	}
	//$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
elseif(!empty($traitName))
{
	//check to see if trait already exists
	$query = $db->prepare("SELECT * FROM Traits WHERE Name=:name");
	$query->execute(array(':name' => $traitName));

	if($query->rowCount() <= 0)
	{
		$query = $db->prepare("INSERT INTO Traits(Name) VALUES(:name)");
		$query->execute(array(':name' => $traitName));	
		
		if($query->rowCount() >= 1)
		{
			$successMessage = "Trait Added Succesfully";
		}
		else
		{
			$errorMessages[] = "Trait not added. Idk why";
		}
		
	}
	else
	{
		$errorMessages[] = "Trait already exist you dumbass";
	}
}
elseif(!empty($rankName))
{
	//check to see if trait already exists
	$query = $db->prepare("SELECT * FROM Ranks WHERE Name=:name");
	$query->execute(array(':name' => $rankName));

	if($query->rowCount() <= 0)
	{
		$query = $db->prepare("INSERT INTO Ranks(Name) VALUES(:name)");
		$query->execute(array(':name' => $rankName));	
		
		if($query->rowCount() >= 1)
		{
			$successMessage = "Rank Added Succesfully";
		}
		else
		{
			$errorMessages[] = "Rank not added. Idk why";
		}
		
	}
	else
	{
		$errorMessages[] = "Rank already exist you dumbass";
	}
}
elseif(!empty($weaponName))
{
	//check to see if trait already exists
	$query = $db->prepare("SELECT * FROM Weapons WHERE Name=:name");
	$query->execute(array(':name' => $weaponName));

	if($query->rowCount() <= 0)
	{
		$ammo = $_POST["ammo"];
		$rof = $_POST["rateOfFire"];
		$damage = $_POST["damage"];

		if(empty($ammo))
		{
			$errorMessages[] = "Need ammo";
		}
		if(empty($rof))
		{
			$errorMessages[] = "Need rate of fire";
		}
		if(empty($damage))
		{
			$errorMessages[] = "Need damage";
		}

		if(empty($errorMessages))
		{
			$query = $db->prepare("INSERT INTO Weapons(Name,Damage,RateOfFire,Ammo) VALUES(:name,:damage,:rof,:ammo)");
			$query->execute(array(':name' => $weaponName,':damage' => $damage,':rof' => $rof,':ammo' => $ammo));	
			
			if($query->rowCount() >= 1)
			{
				$weaponRow = $db->lastInsertId();

				foreach($_POST["wTraits"] as $wTraits)
				{
					$query = $db->prepare("INSERT INTO Weapon_Traits(WeaponID,WeaponTraitID) VALUES(:wpID,:wtID)");
					$query->execute(array(':wpID' => $weaponRow,':wtID' => $wTraits));
				}

				$successMessage = "Weapon Added Succesfully";
			}
			else
			{
				$errorMessages[] = "Weapon not added. Idk why";
			}
		}
	}
	else
	{
		$errorMessages[] = "Weapon already exist you dumbass";
	}
}
elseif(!empty($weaponTrait))
{
	//check to see if trait already exists
	$query = $db->prepare("SELECT * FROM WeaponTraits WHERE Name=:name");
	$query->execute(array(':name' => $weaponTrait));

	if($query->rowCount() <= 0)
	{
		$query = $db->prepare("INSERT INTO WeaponTraits(Name) VALUES(:name)");
		$query->execute(array(':name' => $weaponTrait));	
		
		if($query->rowCount() >= 1)
		{
			$successMessage = "Weapon Trait Added Succesfully";
		}
		else
		{
			$errorMessages[] = "Weapon Trait not added. Idk why";
		}
		
	}
	else
	{
		$errorMessages[] = "Weapon Trait already exist you dumbass";
	}
}



//include header template
require('layout/header.php');
require('layout/layout-helper.php');
?>


<div class="container-fluid">

<?php

//warnings and success messages
if(!empty($errorMessages))
{
	foreach($errorMessages as $message)
	{
		echo createError($message);
	}
}
if(!empty($successMessage))
{
	echo createSuccess($successMessage);
}

?>


	<!--Figure Row-->
	<div class="row">
	    <div class="col-md-6">

			<form role="form" method="post" action="">
				<h2>Create Figure</h2>
				
				<div class="form-group col-md-3">
					<label>Name</label>
					<input type="text" name="figureName" id="figureName" class="form-control input-lg" placeholder="Name" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Alias</label>
					<input required type="text" name="figureAlias" id="figureAlias" class="form-control input-lg" placeholder="Alias" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Reputation Cost</label>
					<input type="number" required min="0" step="1" name="reputationCost" id="reputationCost" class="form-control input-lg" placeholder="Rep Cost" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Funding Cost</label>
					<input type="number" required min="0" step="1" name="fundingCost" id="fundingCost" class="form-control input-lg" placeholder="Funding Cost" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Willpower</label>
					<input type="number" required min="0" step="1" name="willpower" id="willpower" class="form-control input-lg" placeholder="Willpower" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Strength</label>
					<input type="number" required min="0" step="1" name="strength" id="strength" class="form-control input-lg" placeholder="Strength" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Movement</label>
					<input type="number" required min="0" step="1" name="movement" id="movement" class="form-control input-lg" placeholder="Movement" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Attack</label>
					<input type="number" required min="0" step="1" name="attack" id="attack" class="form-control input-lg" placeholder="Attack" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Defense</label>
					<input type="number" required min="0" step="1" name="defense" id="defense" class="form-control input-lg" placeholder="Defense" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Endurance</label>
					<input type="number" required min="0" step="1" name="endurance" id="endurance" class="form-control input-lg" placeholder="Endurance" value="" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Special</label>
					<input type="number" required min="0" step="1" name="special" id="special" class="form-control input-lg" placeholder="Special" value="" tabindex="1">
				</div>

				<div class="form-group col-md-12">
					<label>Special Traits</label>
					<textarea required type="text" name="specialTraits" id="specialTraits" class="form-control input-lg" placeholder="Special Triats" value="" tabindex="1"></textarea>
				</div>

				<div class="form-group col-md-3">
					<h4>Factions</h4>
					<?php
						foreach($db->query('SELECT * FROM Faction') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="factions[]" type="checkbox" value="<?php echo $row['FactionID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>
						<?php
						}
					?>
				</div>

				<div class="form-group col-md-3">
					<h4>Ranks</h4>
					<?php
						foreach($db->query('SELECT * FROM Ranks') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="ranks[]" type="checkbox" value="<?php echo $row['RankID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>

						<?php
						}
					?>
				</div>

				<div class="form-group col-md-3">
					<h4>Traits</h4>
					<?php
						foreach($db->query('SELECT * FROM Traits') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="traits[]" type="checkbox" value="<?php echo $row['TraitID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>

						<?php
						}
					?>
				</div>

				<div class="form-group col-md-3">
					<h4>Weapons</h4>
					<?php
						foreach($db->query('SELECT * FROM Weapons') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="weapons[]" type="checkbox" value="<?php echo $row['WeaponID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>
						<?php
						}
					?>
				</div>

				<div class="form-group col-md-3">
					<h4>Hates Factions</h4>
					<?php
						foreach($db->query('SELECT * FROM Faction') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="hatesFactions[]" type="checkbox" value="<?php echo $row['FactionID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>
						<?php
						}
					?>
				</div>

				<div class="form-group col-md-3">
					<h4>Hates Figures</h4>
					<?php
						foreach($db->query('SELECT * FROM Figures') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="hatesFigures[]" type="checkbox" value="<?php echo $row['FigureID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>
						<?php
						}
					?>
				</div>

				<div class="form-group col-md-3">
					<h4>Affinitys</h4>
					<?php
						foreach($db->query('SELECT * FROM Figures') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="affinitys[]" type="checkbox" value="<?php echo $row['FigureID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>
						<?php
						}
					?>
				</div>

				<div class="row">
					<div class="col-xs-6 col-md-3"><input type="submit" name="submit" value="Create Figure" class="btn btn-primary btn-block btn-md" tabindex="5"></div>
				</div>

			</form>


		</div>

		<!-- show figure stats-->
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2>Figures</h2>
					<?php

					foreach($db->query('SELECT * FROM Figures') as $row) {

						$figurePrimaryKey = $row['FigureID'];?>

						<div class="row">
							<div class="col-md-6">

								<div class="row">
									<div class="col-md-12"><label>Name: </label><?php echo " " . $row['Name'];?></div>
									<div class="col-md-12"><label>Alias: </label><?php echo " " . $row['Alias'];?></div>

									<div class="col-md-12">
										<label>Rank:</label>
											<?php
											$query = $db->prepare('SELECT * FROM Figure_Ranks INNER JOIN Ranks ON Figure_Ranks.Rank=Ranks.RankID WHERE Figure_Ranks.Figure=:figureID');
											$query->execute(array(':figureID' => $figurePrimaryKey));
											$result = $query->fetchAll(PDO::FETCH_ASSOC);
											if(empty($result))
											{
												echo "none";
											}else
											{
												foreach($result as $rank)
												{
													?>
													<?php echo $rank["Name"] . " ";?>
													<?php
												}
											}
											?>
									</div>

									<div class="col-md-12">
										<label>Faction:</label>
											<?php
											$query = $db->prepare('SELECT * FROM Figure_Factions INNER JOIN Faction ON Figure_Factions.Faction=Faction.FactionID WHERE Figure_Factions.Figure=:figureID');
											$query->execute(array(':figureID' => $figurePrimaryKey));
											$result = $query->fetchAll(PDO::FETCH_ASSOC);
											if(empty($result))
											{
												echo "none";
											}else
											{
												foreach($result as $faction)
												{
													?>
													<?php echo $faction["Name"] . " ";?>
													<?php
												}
											}
											?>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="row">
									<div class="col-md-2"><label>Strength</label><p class="centered"><?php echo $row['Strength'];?></p></div>
									<div class="col-md-2"><label>Movement</label><p class="centered"><?php echo $row['Movement'];?></p></div>
									<div class="col-md-2"><label>Attack</label><p class="centered"><?php echo $row['Attack'];?></p></div>
									<div class="col-md-2"><label>Defense</label><p class="centered"><?php echo $row['Defense'];?></p></div>
									<div class="col-md-2"><label>Endurance</label><p class="centered"><?php echo $row['Endurance'];?></p></div>
									<div class="col-md-2"><label>Special</label><p class="centered"><?php echo $row['Special'];?></p></div>
								</div>
							
							</div>
						</div>

						<!--figure weapon-->
						<div class="row">
							<div class="col-md-12">
							<p><b>Weapons:</b></p>
							<?php
								$query = $db->prepare('SELECT * FROM Figure_Weapons INNER JOIN Weapons ON Figure_Weapons.Weapon=Weapons.WeaponID WHERE Figure_Weapons.Figure=:figureID');
								$query->execute(array(':figureID' => $figurePrimaryKey));
								$result = $query->fetchAll(PDO::FETCH_ASSOC);
								if(empty($result))
								{
									echo "none";
								}else
								{
									foreach($result as $weapon)
									{?>
										<div class="row">
											<div class="col-md-3">
												<label>Name:</label>
												<?php echo $weapon["Name"] . " ";?>	
											</div>
											<div class="col-md-1">
												<label>Damage</label>
												<p class="centered"><?php echo $weapon["Damage"] . " ";?></p>
											</div>
											<div class="col-md-2">
												<label>Rate Of Fire</label>
												<p class="centered"><?php echo $weapon["RateOfFire"] . " ";?></p>
											</div>
											<div class="col-md-1">
												<label>Ammo</label>
												<p class="centered"><?php echo $weapon["Ammo"] . " ";?>	</p>
											</div>
											<div class="col-md-3">
												<p class="centered"><b>Special</b></p>
												<?php
													$query = $db->prepare(
														'SELECT *
														FROM `WeaponTraits`
														INNER JOIN Weapon_Traits ON WeaponTraits.WeaponTraitID=Weapon_Traits.WeaponTraitID
														INNER JOIN Figure_Weapons ON Weapon_Traits.WeaponID=Figure_Weapons.Weapon
														WHERE Figure_Weapons.Figure=:figureID AND Figure_Weapons.Weapon=:weaponID'
													);
													$query->execute(array(':figureID' => $figurePrimaryKey, ':weaponID' => $weapon["Weapon"]));
													$weaponTraits = $query->fetchAll(PDO::FETCH_ASSOC);
													if(empty($weaponTraits))
													{
														echo "none";
													}else
													{
														foreach($weaponTraits as $weaponTr)
														{?>
															<p class="centered"><?php echo $weaponTr["Name"] . " ";?></p>
														<?php
														}
													}
												?>
											</div>
										</div>
			
									<?php
									}
								}
								?>
							</div>
						</div>
						<!--end figure weapon-->

						<br>

						<div class="row">
							<div class="col-md-12"><label>Special Traits:</label><div style="max-width:500px; padding-left:50px;" ><?php echo $row['SpecialTraits'];?></div></div>
						</div>

						<div class="row">
							<div class="col-md-6"><label>Reputation Cost:</label><?php echo " " . $row['ReputationCost'];?></div>
							<div class="col-md-6"><label>Funding Cost:</label><?php echo " $" . $row['FundingCost'];?></div>
						</div>

						<div class="row">
							<div class="col-md-12"><label>Willpower:</label><?php echo " " . $row['Willpower'];?></div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<p><b>Personal Traits:</b></p>
								
								<?php
									$query = $db->prepare(
										'SELECT *
										FROM `Traits`
										INNER JOIN Figure_Traits ON Figure_Traits.Trait=Traits.TraitID
										WHERE Figure_Traits.Figure=:figureID'
									);
									$query->execute(array(':figureID' => $figurePrimaryKey));
									$personalTraits = $query->fetchAll(PDO::FETCH_ASSOC);
									if(empty($personalTraits))
									{
										echo "none";
									}else
									{
										foreach($personalTraits as $personalTr)
										{?>
												<div class="col-md-6"><?php echo $personalTr["Name"] . " ";?>
												</div>
										<?php
										}

									}


								?>
							</div>
						</div>

						<br>

						<div class="row">
							<div class="col-md-12">
								<h4>Relationships</h4>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<p><b>Hates Figures:</b></p>
								
								<?php
									$query = $db->prepare(
										'SELECT *
										FROM `Figures`
										INNER JOIN Figure_HatesFigure ON Figure_HatesFigure.Hated=Figures.FigureID
										WHERE
										Figure_HatesFigure.Hater=:figureID'
									);
									$query->execute(array(':figureID' => $figurePrimaryKey));
									$hateFigure = $query->fetchAll(PDO::FETCH_ASSOC);
									if(empty($hateFigure))
									{
										echo "none";
									}else
									{
										foreach($hateFigure as $hateFig)
										{?>
												<div class="col-md-3"><?php echo $hateFig["Name"] . " ";?>
												</div>
										<?php
										}

									}


								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<p><b>Hates Faction:</b></p>
								
								<?php
									$query = $db->prepare(
										'SELECT *
										FROM `Faction`
										INNER JOIN Figure_HatesFaction ON Figure_HatesFaction.FactionID=Faction.FactionID
										WHERE
										Figure_HatesFaction.FigureID=:figureID'
									);
									$query->execute(array(':figureID' => $figurePrimaryKey));
									$hateFaction = $query->fetchAll(PDO::FETCH_ASSOC);
									if(empty($hateFaction))
									{
										echo "none";
									}else
									{
										foreach($hateFaction as $hateFac)
										{?>
												<div class="col-md-3"><?php echo $hateFac["Name"] . " ";?>
												</div>
										<?php
										}

									}


								?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<p><b>Affinitys:</b></p>
								
								<?php
									$query = $db->prepare(
										'SELECT *
										FROM `Figures`
										INNER JOIN Figure_Affinitys ON Figure_Affinitys.LovedID=Figures.FigureID
										WHERE
										Figure_Affinitys.LoverID=:figureID'
									);
									$query->execute(array(':figureID' => $figurePrimaryKey));
									$affinitys = $query->fetchAll(PDO::FETCH_ASSOC);
									if(empty($affinitys))
									{
										echo "none";
									}else
									{
										foreach($affinitys as $aff)
										{?>
												<div class="col-md-3"><?php echo $aff["Name"] . " ";?>
												</div>
										<?php
										}

									}


								?>
							</div>
						</div>

						<hr>

					<?php
					}
					
					?>

				</div>
			</div>
		</div>
	</div>
	<!--END Figure Row-->


	<hr>

	<!--Faction Row-->
	<div class="row">
	    <div class="col-md-6">
			<form role="form" method="post" action="">
				<h2>Create Faction</h2>
				
				<div class="form-group">
					<input type="text" name="factionName" id="factionName" class="form-control input-lg" placeholder="Faction Name" value="<?php if(isset($error)){ echo $factionName; } ?>" tabindex="1">
				</div>
			
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Create Faction" class="btn btn-primary btn-block btn-md" tabindex="5"></div>
				</div>

			</form>
		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2>Factions</h2>
					<?php
					
					foreach($db->query('SELECT * FROM Faction') as $row) {?>
						<p><?php echo $row['Name'];?></p>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<!--END Faction Row-->

	<hr>

	<!--Trait Row-->
	<div class="row">
	    <div class="col-md-6">
			<form role="form" method="post" action="">
				<h2>Create Trait</h2>
				
				<div class="form-group">
					<input type="text" name="traitName" id="traitName" class="form-control input-lg" placeholder="Trait Name" value="<?php if(isset($error)){ echo $traitName; } ?>" tabindex="1">
				</div>
			
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Create Trait" class="btn btn-primary btn-block btn-md" tabindex="5"></div>
				</div>

			</form>
		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2>Traits</h2>
					<?php
					
					foreach($db->query('SELECT * FROM Traits') as $row) {?>
						<p><?php echo $row['Name'];?></p>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<!--END Trait Row-->

	<hr>

	<!--Rank Row-->
	<div class="row">
	    <div class="col-md-6">
			<form role="form" method="post" action="">
				<h2>Create Rank</h2>
				
				<div class="form-group">
					<input type="text" name="rankName" id="rankName" class="form-control input-lg" placeholder="Rank Name" value="<?php if(isset($error)){ echo $rankName; } ?>" tabindex="1">
				</div>
			
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Create Rank" class="btn btn-primary btn-block btn-md" tabindex="5"></div>
				</div>

			</form>
		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2>Ranks</h2>
					<?php
					
					foreach($db->query('SELECT * FROM Ranks') as $row) {?>
						<p><?php echo $row['Name'];?></p>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<!--END Rank Row-->

	<hr>

	<!--Weapon  Row-->
	<div class="row">
	    <div class="col-md-6">
			<form role="form" method="post" action="">
				<h2>Create Weapon</h2>
				
				<div class="form-group col-md-3">
					<label>Weapon Name</label>
					<input type="text" name="weaponName" id="weaponName" class="form-control input-lg" placeholder="Weapon Name" value="<?php if(isset($errorMessages)){ echo $weaponName; } ?>" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Damage</label>
					<input type="number" required min="0" step="1" name="damage" id="damage" class="form-control input-lg" placeholder="Damage" value="<?php if(isset($errorMessages)){ echo $damage; }else{} ?>" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Ammo</label>
					<input type="number" required min="0" step="1" name="ammo" id="ammo" class="form-control input-lg" placeholder="Ammo" value="<?php if(isset($errorMessages)){ echo $ammo; }else{} ?>" tabindex="1">
				</div>
				<div class="form-group col-md-3">
					<label>Rate of Fire</label>
					<input type="number" required min="0" step="1" name="rateOfFire" id="rateOfFire" class="form-control input-lg" placeholder="Rate of Fire" value="<?php if(isset($errorMessages)){ echo $rateOfFire; }else{} ?>" tabindex="1">
				</div>

				<div class="form-group col-md-4">
					<h4>Weapon Traits</h4>
					<?php
						foreach($db->query('SELECT * FROM WeaponTraits') as $row) {?>
							<div class="col-md-6">
								<div class="checkbox">
								 	<label><input name="wTraits[]" type="checkbox" value="<?php echo $row['WeaponTraitID'];?>"><?php echo $row['Name'];?></label>
								</div>
							</div>

						<?php
						}
					?>
				</div>
			
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Create Weapon" class="btn btn-primary btn-block btn-md" tabindex="5"></div>
				</div>

			</form>
		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2>Weapons</h2>
					<?php
					
					foreach($db->query('SELECT * FROM Weapons') as $row) {?>
						<div class="col-md-2"><label>Name</label><p><?php echo $row['Name'];?></p></div>
						<div class="col-md-2"><label>Damage</label><p><?php echo $row['Damage'];?></p></div>
						<div class="col-md-2"><label>Ammo</label><p><?php echo $row['RateOfFire'];?></p></div>
						<div class="col-md-2"><label>Rate of Fire</label><p><?php echo $row['Ammo'];?></p></div>
						<div class="col-md-4">
							<label>Traits</label>
								<?php
								$query = $db->prepare('SELECT * FROM WeaponTraits INNER JOIN Weapon_Traits ON Weapon_Traits.WeaponTraitID=WeaponTraits.WeaponTraitID WHERE Weapon_Traits.WeaponID=:wID');
								$query->execute(array(':wID' => $row["WeaponID"]));
								$tr = $query->fetchAll(PDO::FETCH_ASSOC);
								if(empty($tr))
								{
									echo "<p>none</p>";
								}else
								{
									foreach($tr as $wtrait)
									{
										?>
										<p><?php echo $wtrait["Name"];?></p>
										<?php
									}
								}
								?>
						</div>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<!--END Weapon Row-->

	<hr>

	<!--Weapon Trait Row-->
	<div class="row">
	    <div class="col-md-6">
			<form role="form" method="post" action="">
				<h2>Create Weapon Trait</h2>
				
				<div class="form-group">
					<input type="text" name="weaponTrait" id="weaponTrait" class="form-control input-lg" placeholder="Weapon Trait Name" value="<?php if(isset($error)){ echo $weaponTrait; } ?>" tabindex="1">
				</div>
			
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Create Weapon Trait" class="btn btn-primary btn-block btn-md" tabindex="5"></div>
				</div>

			</form>

		</div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<h2>Weapon Trait</h2>
					<?php
					
					foreach($db->query('SELECT * FROM WeaponTraits') as $row) {?>
						<p><?php echo $row['Name'];?></p>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<!--END Weapon Trait Row-->

</div>

<?php 
//include header template
require('layout/footer.php'); 
?>
