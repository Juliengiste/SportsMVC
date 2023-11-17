<style>
.carousel-control-prev-icon, .carousel-control-next-icon {
    height: 100px;
    width: 100px;
    outline: black;
    background-color: grey;
    background-size: 100%, 100%;
    border-radius: 50%;
    border: 1px solid black;
}

body {
	margin-top: 50px;
	/* background-color: #7c7ef8; */
	font-family: "Ubuntu", sans-serif;
	/*display: flex;
	align-items: stretch;
	padding: 0;
	margin: 0;*/
}

table,
td {
	border: 1px solid #23232324;
	cursor: copy;
}

tr {
	cursor: default;
}

table {
	/* margin: 14px auto;
	padding: 7vh 0;
	border-collapse: collapse; */
	margin: 14px auto;
	padding: 0.5vh 0.5vh;
	border-collapse: collapse;
	box-shadow: 0px 0px 149px -28px #1b19cdd1;
	border-radius: 20px;
	overflow: hidden;
	border-color: transparent;
}

/* .font {
	font-family: "Dank Mono", Impact, Haettenschweiler, "Arial Narrow Bold",
		sans-serif;
} */

.date-title {
        display: inline;
        margin-right: 10px; /* Espacez les titres de date si nécessaire */
    }

.default-cursor {
	cursor: default;
}

.center {
	text-align: center;
}

.btn {
	border-radius: 100px;
	outline: none;
	margin: 0 auto;
	background-color: transparent;
}

.color {
	color: #fefdfd;
	background-color: #1b19cd;
}

.border-color {
	background-color: #1b19cd;
}

.off-color {
	color: #7c7ef8;
}

#current-day-info {
	min-height: 5vh;
	width: 100%;
}

#current-day-info #app-name-landscape {
	font-size: 6.2vh;
	padding: 0.5vh 0 1vh;
	border-bottom: 1px solid;
	color: white;
}

.time {
	text-align: center;
	padding-bottom: 5vh;
	font-size: 3vh;
	font-weight: lighter;
	text-shadow: 0px 0px 10px aliceblue;
	cursor: pointer;
}

.time:hover,
.verb {
	text-decoration-line: underline;
	text-decoration-style: wavy;
	text-decoration-color: green;
}

#current-day-info h2 {
	font-size: 6.2vh;
	font-weight: 300;
	margin: 0 0 1vh;
	padding-top: 3vh;
}

#current-day-info h1 {
	font-size: 6.8vh;
	font-weight: 600;
	margin: 1vh 0;
}

#current-day-info #theme-landscape,
#calender #theme-portrait {
	display: block;
	padding: 1vh 1vh;
	box-shadow: #a9a7a7 0px 0px 91px -5px;
	/* padding: 16px 38px; */
	color: #d2cdcd;
	/* background-color: #e9e7e7; */
	border: 2px solid transparent;
	font-size: 2.4vh;
}

#current-day-info #theme-landscape:hover,
#calender #theme-portrait:hover {
	background-color: white;
	opacity: 0.4;
	color: black;
}

#calender {
	width: 100%;
	min-height: 45vh;
	display: flex;
	flex-direction: column;
	justify-content: space-around;
	/* align-content: center; */
}

#calender #app-name-portrait {
	display: none;
}

#calender #theme-portrait {
	display: none;
}

#calender thead tr:first-child th div {
	display: flex;
	align-content: center;
	justify-content: center;
	align-items: center;
}

#calender h4 {
	margin: 0;
	padding: 0.8vh 0 0.2vh;
	font-size: 1.4vw;
	font-weight: 300;
}

#calender h3 {
	font-size: 2vw;
	font-weight: 700;
	padding: 0 1vw;
	margin: 0;
	display: inline-block;
}

#calender .weekday {
	font-size: 1.7vw;
	font-weight: 300;
	padding: 8px 0 5px;
	/* border: 1px solid transparent; */
	/* border-bottom: 1px solid white !important; */
}

#calender .icon {
	font-size: 1.3rem;
}

#calender .icon:hover {
	opacity: 0.6;
}

#calender tbody td {
	height: 9.2vh;
	width: 6.5vw;
	font-size: 1.3vw;
	font-weight: 600;
	vertical-align: top;
	padding: 0.5vw;
	transition: font-size 0.4s ease;
}

#calender tbody td:hover {
	font-size: 2vw;
}

#calender #current-day {
	background-color: #e1e1e1;
}

#calender img {
	width: 4.7rem;
	vertical-align: top;
	position: relative;
	top: 0.1vw;
	left: 20px;
}

#calender .day {
	display: block;
	max-height: 10px;
}

.tooltip {
	display: none;
	cursor: none;
}

@media (orientation: landscape) {
	.tooltip-container:hover {
		cursor: pointer;
	}

	.tooltip-container:hover .tooltip {
		/* font-size: 1.5vw; */
		font-size: 1.1vw;
		font-weight: initial;
		display: block;
		position: absolute;
		white-space: pre-wrap;
		/* width: 12vw; */
		background-color: #ededed;
		color: black;
		border-radius: 10px;
		/* padding: 1vw 0.1vw; */
		padding: 0.5vw;
		text-align: center;
		border: 1px solid #1b19cd14;
		box-shadow: 0px 3px 12px -6px black;
	}
}

.modal {
	display: none;
	height: 100%;
	width: 100%;
	border: none;
	padding: 0;
	background-color: rgba(29, 29, 29, 0.85);
	position: fixed;
}

.popup {
	position: static;
	display: flex;
	flex-direction: column;
	width: 48vw;
	align-items: center;
	margin: 14vh auto 0;
	background-color: #fefdfd;
	border-radius: 10px;
}

.fade-in {
	animation: fade-in 0.8s ease-out;
}

.fade-out {
	animation: fade-out 0.5s ease-out;
}

@keyframes fade-in {
	0% {
		opacity: 0;
	}

	100% {
		opacity: 1;
	}
}

@keyframes fade-out {
	0% {
		opacity: 1;
	}

	100% {
		opacity: 0;
	}
}

#fav-color h4 {
	margin: 32px 0 18px;
	font-size: calc(15px + 1.8vw);
	font-weight: 400;
	border-bottom: 1px solid #232323;
	padding: 0 4vw;
}

#fav-color #color-options {
	width: 84%;
	margin: 0 10px;
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
}

#fav-color #color-options h5 {
	display: inline;
	margin: 8px 0 8px;
	font-size: calc(6px + 0.6vw);
	font-weight: 500;
}

#fav-color #color-options .color-option {
	margin: 0.2vh 0.4vw;
	width: 5vw;
	text-align: center;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: start;
}

#fav-color #color-options .color-preview {
	height: calc(16px + 1.7vw);
	width: calc(16px + 1.7vw);
	border-radius: 100px;
	padding: 0;
	display: flex;

	justify-content: center;

	align-content: center;

	flex-direction: column;
}

#fav-color #color-options .color-preview:hover,
.selectedColor {
	opacity: 0.8;
	border: 5px solid gray;
	padding: 0.5px;
}

#fav-color #color-options .checkmark {
	color: white;
	font-size: 1.2vw;
}

#fav-color #update-theme-button {
	margin: 24px 0 20px;
	padding: 10px 26px;
	font-size: calc(8px + 1.3vw);
	border: 3px solid #232323;
	color: #232323;
	background-color: #fff;
}

#fav-color #update-theme-button:hover {
	opacity: 0.4;
	border-color: transparent;
	background-color: #e1e1e1;
}

#make-note {
	display: flex;
	place-content: center;
	text-align: center;
	margin: 0px auto;
	width: 50%;
}

#make-note h4 {
	text-align: center;
	margin: 30px 0 16px;
	font-size: calc(16px + 1.5vw);
	font-weight: 300;
}

#make-note #edit-post-it {
	height: 340px;
	width: 85%;
	font-size: 2.6vw;
	padding: 14px;
	border: 1px solid #d8d8d8;
	border-radius: 10px;
	outline: none;
	resize: none;
}

#make-note .post-it-button {
	display: inline;
	margin: 14px 0 20px;
	padding: 10px 26px;
	font-size: calc(12px + 0.6vw);
	font-weight: 400;
}

#make-note #add-post-it {
	border: 3px solid #222;
}

#make-note #add-post-it:hover {
	color: white;
	background-color: #222;
}

#make-note #delete-button {
	color: white;
	border: 3px solid #d71c1f;
	background-color: #d71c1f;
}

#make-note #delete-button:hover {
	color: #d71c1f;
	border: 3px solid #d71c1f;
	background-color: white;
}

@media (orientation: portrait) {
	body {
		flex-direction: column;
	}

	.time {
		display: none;
	}

	/* #date {
		display: flex;
		justify-content: space-between;
	} */

	/* #current-year {
		padding-bottom: 2px;
	} */

	#calender {
		width: 100%;
		justify-content: none;
		min-height: initial;
	}
	#calender img {
		/* width: 2rem */
		display: none;
	}
	table {
		/* margin: 0 50px 10vh 50px; */
		/* margin-bottom: 10vh; */
		font-size: 0.8rem;
	}

	#calender .weekday {
		font-size: 0.8rem;
	}

	#calender #cal-year {
		font-size: 1.2rem;
	}

	#calender #cal-month {
		font-size: 1rem;
	}

	#calender td {
		font-size: 0.8rem !important;
		font-weight: 300;
	}

	#current-day-info {
		min-height: initial;
		height: 13vh;
		width: 100%;
		/* display: none; */
		padding: 1vw 0;
		display: flex;
		flex-direction: column;
		/* justify-content: space-between; */
		align-items: center;
		align-content: center;
	}

	#current-day-info .current-day-heading {
		display: inline;
		padding: 0;
		margin: 0 4px;
		font-size: 5vw;
	}

	#current-day-info .current-month-heading {
		display: inline;
		padding: 0;
		margin: 0 4px;
		font-size: 5vw;
	}

	#current-day-info .current-date-heading {
		display: inline;
		padding: 0;
		margin: 0 4px;
		font-size: 5vw;
	}

	#current-day-info #app-name-landscape {
		padding: 1vh 0 1vh;
		border-bottom: 1px solid;
		display: none;
		color: white;
	}

	#current-day-info h2 {
		font-size: 3vh;
		/* font-weight: 300;
		margin: 0 0 1.5vh;
		padding-top: 1.5vh; */
	}

	#current-day-info h1 {
		font-size: 4vh;
		/* font-weight: 600;
		margin: 2.3vh 0; */
	}

	#current-day-info #theme-landscape {
		display: none;
	}

	#calender #theme-portrait {
		display: block;
		/* padding: 3vw 25vw; */
		width: 100%;
		border-radius: 100px;
	}

	#calender #app-name-portrait {
		display: block;
		/* margin: 1vw; */
	}

	#calender tbody td {
		height: 7.2vw;
		width: 9.2vw;
	}
}

@media (orientation: portrait) {
	.popup {
		width: 87vw;
	}

	#fav-color .popup h4 {
		text-align: center;
	}

	#fav-color #color-options .color-option {
		width: 8vw;
	}

	/* #make-note .popup h4 {} */

	#make-note {
		width: 75%;
	}

	#make-note #edit-post-it {
		height: 200px;
		width: 85%;
	}
}

.fa-sticky-note {
	color: rgba(255, 187, 61, 0.5);
	font-size: 2rem;
}

.note-title {
	width: 85%;
	font-size: 1.6vw;
	padding: 14px;
	border: 1px solid #d8d8d8;
	border-radius: 10px;
	outline: none;
}

#todayLogo {
	width: 3rem;
	top: 0.8vw;
	left: 1px;
}

</style>
<?php
/*******************************
Version : 1.0.0.0
Revised : jeudi 19 avril 2018, 16:49:24 (UTC+0200)
*******************************/
if(isset($_SESSION[SHORTNAME.'_user'])) $me = $_SESSION[SHORTNAME.'_user'];

?>
<div class="container mt-3" id="content" style="margin-top: 150px;">

	<div class="container-fluid">
		<section>
            <aside>
                <h1>Top Infos  S . M . S </h1>
                <div class="container-fluid row">
                	<div class="card mr-3" style="width: 18rem;">
					  	<img class="card-img-top" src="/template/assets/img/404.jpg" alt="Card image cap">
					 	<div class="card-body">
					    	<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					  	</div>
					</div>
					<div class="card mr-3" style="width: 18rem;">
					  	<img class="card-img-top" src="/template/assets/img/404.jpg" alt="Card image cap">
					  	<div class="card-body">
					    	<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					  	</div>
					</div>
					<div class="card" style="width: 18rem;">
					  	<img class="card-img-top" src="/template/assets/img/404.jpg" alt="Card image cap">
					  	<div class="card-body">
					    	<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
					  	</div>
					</div>
				</div>
            </aside>

            <article>               
                <h1>L'association Sédélocienne Multi Sports</h1>
                <p>Superbe association créée au 4ème siècle avant JC. Possibilité de jouer au tennis de table, au badminton et au volley. De nombreuses séances sont disponibles sur inscription. Les inscriptions sont obligatoires dans le but d'avoir un suivi des participants.</p>
            </article>
	





























	<section class="row">
            <!-- calendar -->
           	<div id="current-day-info" class="color col-md-12">
				<h3 id="app-name-landscape" class="off-color center default-cursor">
			Agenda
				</h3>

				<div>
					
				</div>

				<div class="color center">
					<h3 class="date-title" id="cur-day" class="current-day-heading center default-cursor"></h3>
				    <h3 class="date-title" id="cur-date" class="current-date-heading center default-cursor"></h3>
				    <h3 class="date-title" id="cur-month" class="current-month-heading center default-cursor"></h3>
				    <h3 class="date-title" id="current-year" class="center default-cursor "></h3>
				</div>
			<!--	<button id="theme-landscape" class="font btn">Change Theme</button>-->
			</div>

	<div class="color col-md-12" id="calender">
		<h1 id="app-name-portrait" class="center ">Cal</h1>
		<!-- h1 'off-color' class was removed -->
		<table>
			<thead class="color">
				<tr>
					<th colspan="7" class="border-color">
						<h4 id="cal-year" contenteditable="true">2018</h4>
						<div>
							<i class="fas fa-caret-left icon"> </i>
							<h3 id="cal-month">july</h3>
							<i class="fas fa-caret-right icon"> </i>
						</div>
					</th>
				</tr>

				<tr>
					<th class="weekday border-color">Dim</th>
					<th class="weekday border-color">Lun</th>
					<th class="weekday border-color">Mar</th>
					<th class="weekday border-color">Mer</th>
					<th class="weekday border-color">Jeu</th>
					<th class="weekday border-color">Ven</th>
					<th class="weekday border-color">Sam</th>
				</tr>
			</thead>

			<tbody id="table-body">
				<tr>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
				</tr>
				<tr>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
				</tr>
				<tr>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
				</tr>
				<tr>
					<td>1</td>
					<td>1</td>
					<td class="tooltip-container">
						<span class="day">1</span>
						<img src="/template/assets/img/logo SMS.png" alt="note" />
						<span class="tooltip"> this is pretty tooltip</span>
					</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
				</tr>
				<tr>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
				</tr>
				<tr>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
					<td>1</td>
				</tr>
			</tbody>
		</table>
		<button id="theme-portrait" class="font btn">Change Theme</button>
	</div>
		<div id="make-note" hidden>
			<div class="popup">
				<h4> <span class="verb"></span> note on <span id="noteDate">2019 12 5</span></h4>
				<input class="note-title" type="text" name="title" placeholder="note title ..." />
				<textarea class="note-content" id="edit-post-it" name="post-it"
					placeholder="note description ..."></textarea>
				<span style="color:red;" id="warning"></span>
				<div>
					<button class="btn font post-it-button" id="add-post-it">
						Save
					</button>
					<button class="btn font post-it-button" id="delete-button">
						Delete
					</button>
				</div>
			</div>
		</div>
	</div>
	</section>
            <!-- calendar -->

        </section>
	</div>
</div>



<script type="text/javascript">
	const currentDayDOM = document.getElementById("cur-day"),
	currentMonthDOM = document.getElementById("cur-month"),
	calenderMonthDOM = document.getElementById("cal-month"),
	currentDateDOM = document.getElementById("cur-date"),
	calenderYearDOM = document.getElementById("cal-year"),
	currentYearDOM = document.getElementById("current-year"),
	noteDateInPopup = document.getElementById("noteDate"),
	saveBtnInPopup = document.getElementById("add-post-it"),
	deleteBtnInPopup = document.getElementById("delete-button"),
	noteContentInput = document.querySelector(".note-content"),
	noteTitleInput = document.querySelector(".note-title"),
	verb = document.querySelector(".verb"),
	modal = document.querySelector(".modal"),
	colorModal = document.getElementById("fav-color"),
	popup = document.querySelector(".popup"),
	noteModal = document.getElementById("make-note");

document.querySelector(".fa-caret-left").addEventListener("click", prevMonth);
document.querySelector(".fa-caret-right").addEventListener("click", nextMonth);

const now = new Date();
//for testing purposes use 'let' instead of 'const'
let todayDay = now.getDay(),
	todayDate = now.getDate(),
	todayMonth = now.getMonth(),
	todayYear = now.getFullYear();

let state = {
	todayDay,
	todayDate,
	todayMonth,
	todayYear
};
let daysStr = {
	0: "Dimanche",
	1: "Lundi",
	2: "Mardi",
	3: "Mercredi",
	4: "Jeudi",
	5: "Vendredi",
	6: "Samedi"
};
let daysIndex = {
	Sun: 0,
	Mon: 1,
	Tue: 2,
	Wed: 3,
	Thu: 4,
	Fri: 5,
	Sat: 6
};
let monthsStr = {
	0: "Jan",
	1: "Feb",
	2: "Mar",
	3: "Apr",
	4: "May",
	5: "Jun",
	6: "Jul",
	7: "Aug",
	8: "Sep",
	9: "Oct",
	10: "Nov",
	11: "Dec"
};
let monthsIndex = {
	Jan: 0,
	Feb: 1,
	Mar: 2,
	Apr: 3,
	May: 4,
	Jun: 5,
	Jul: 6,
	Aug: 7,
	Sep: 8,
	Oct: 9,
	Nov: 10,
	Dec: 11
};
let color_data = [
	{
		id: 0,
		name: "blue",
		value: "#1B19CD"
	},
	{
		id: 1,
		name: "red",
		value: "#D01212"
	},
	{
		id: 2,
		name: "purple",
		value: "#721D89"
	},
	{
		id: 3,
		name: "green",
		value: "#158348"
	},
	{
		id: 4,
		name: "orange",
		value: "#EE742D"
	},
	{
		id: 5,
		name: "deep-orange",
		value: "#F13C26"
	},
	{
		id: 6,
		name: "baby-blue",
		value: "#31B2FC"
	},
	{
		id: 7,
		name: "cerise",
		value: "#EA3D69"
	},
	{
		id: 8,
		name: "lime",
		value: "#2ACC32"
	},
	{
		id: 9,
		name: "teal",
		value: "#2FCCB9"
	},
	{
		id: 10,
		name: "pink",
		value: "#F50D7A"
	},
	{
		id: 11,
		name: "black",
		value: "#212524"
	}
];

var currentColor;

let staticCurrentColor = {
	id: 0,
	name: color_data[0].name,
	value: color_data[0].value
};

var notes;
let staticNotes = [
	{
		id: 235684345,
		title: "running marathon",
		desc:
			"blah lbah lorem ipsum sodem qwerty oiuy lorem ipsum sodem qwerty oiuy",
		date: "2019 10 31"
	},
	{
		id: 784534534,
		title: "The Burger Chief opening event",
		desc: "lorem ipsum sodem qwerty oiuy lorem ipsum sodem qwerty oiuy",
		date: "2019 10 2"
	},
	{
		id: 345463516,
		title: "Jamal's Birthday",
		desc: "lorem ipsum sodem qwerty oiuy lorem ipsum sodem qwerty oiuy",
		date: "2019 11 22"
	}
];

let notesFound = localStorage.getItem("notes");
let colorsFound = localStorage.getItem("theme");

if (!notesFound) {
	console.log("notes not Found");
	localStorage.setItem("notes", JSON.stringify(staticNotes));
	notes = staticNotes;
} else {
	notes = JSON.parse(notesFound);
}

if (!colorsFound) {
	console.log("colors not Found:");
	localStorage.setItem("theme", JSON.stringify(staticCurrentColor));
	currentColor = staticCurrentColor;
} else {
	currentColor = JSON.parse(colorsFound);
	applyTheme();
}

//update local storage
function updateLocalStorage() {
	let currentNotes = notes;
	localStorage.setItem("notes", JSON.stringify(currentNotes));
	localStorage.setItem("theme", JSON.stringify(currentColor));
	applyTheme();
}

function applyTheme() {
	document.querySelector(
		"table"
	).style.boxShadow = `0px 0px 149px -28px ${currentColor.value}`;

	document.querySelector(
		".color"
	).style.backgroundColor = `${currentColor.value}`;

	document.querySelector(
		".border-color"
	).style.backgroundColor = `${currentColor.value}`;

	for (let i = 0; i < 7; i++) {
		document.querySelectorAll(".weekday")[
			i
		].style.backgroundColor = `${currentColor.value}`;
	}
}

currentDayDOM.innerHTML = daysStr[todayDay];
currentDateDOM.innerHTML = todayDate;
currentMonthDOM.innerHTML = monthsStr[state.todayMonth];
currentYearDOM.innerHTML = todayYear;
var currentFullYear = analyizYear(state.todayYear);
var currentFullMonth = currentFullYear.months[monthsStr[state.todayMonth]];

//run App
showCalenderInfo();

//exp: analyizYear(2019) will get you all months length,first day,last day with indexes
function analyizYear(year) {
	let counter = 0;
	const currentYear = {
		year: year,
		is_leap: false,
		months: {
			Jan: 0,
			Feb: 1,
			Mar: 2,
			Apr: 3,
			May: 4,
			Jun: 5,
			Jul: 6,
			Aug: 7,
			Sep: 8,
			Oct: 9,
			Nov: 10,
			Dec: 11
		}
	};

	while (counter < 12) {
		Object.keys(currentYear.months).forEach(month => {
			currentYear.months[month] = analyizMonth(month, year);
		});
		counter++;
	}
	if (currentYear.months["Feb"].days_length === 29) {
		currentYear.is_leap = true;
	}
	return currentYear;
}
//exp: run analyizMonth(String:'Dec',Int:2019) note:(must capitalize month like Sep,Nov)
function analyizMonth(month, year) {
	const testDays = 31;
	let counter = 0;

	const monthObj = {
		year: year,
		month: month,
		month_idx: monthsIndex[month],
		first_day: "",
		first_day_index: null,
		days_length: 0,
		last_day_index: null
	};

	while (counter < testDays) {
		counter++;
		const dateTest = `${counter} ${month} ${year}`;
		const dateArr = new Date(dateTest).toDateString().split(" ");
		if (dateArr[1] === month) {
			if (counter === 1) {
				monthObj.first_day = dateArr[0];
				monthObj.first_day_index = daysIndex[dateArr[0]];
			}
			monthObj.days_length++;
			monthObj.last_day = dateArr[0];
			monthObj.last_day_index = daysIndex[dateArr[0]];
		} else {
			return monthObj;
		}
	}
	return monthObj;
}

//get last month days in current month view
function makePrevMonthArr(firstDayIndex) {
	let prevMonthIdx;
	let prevMonthDays;
	if (state.todayMonth === 0) {
		prevMonthDays = analyizMonth("Dec", state.todayYear - 1).days_length;
	} else {
		prevMonthIdx = monthsIndex[currentFullMonth.month] - 1;
		prevMonthDays = currentFullYear.months[monthsStr[prevMonthIdx]].days_length;
	}
	let result = [];
	for (let i = 1; i <= firstDayIndex; i++) {
		const day = prevMonthDays - firstDayIndex + i;
		result.push({ day, state: "prevMonth" });
	}

	return result;
	//**** previous version of this code was returning just days without state
	//**** like [1,2,3] instead of day and its state like [{day:1,"prevMonth"}]
	// return Array.from(
	// 	{ length: firstDayIndex },
	// 	(_, i) => prevMonthDays - firstDayIndex + i
	// );
}
// this will print an array of with days of prev month and next month crosponds to the calender table
function calcMonthCalendar() {
	// Create array: [1, 2, 3, ..., 30, 31]
	const currMonth = Array.from(
		{ length: currentFullMonth.days_length },
		(_, i) => ({ day: i + 1, state: "currMonth" })
	);

	const nextMonth = Array.from(
		{ length: currentFullMonth.days_length },
		(_, i) => ({ day: i + 1, state: "nextMonth" })
	);

	// Create a flat array with leading zeros and trailing last week:
	// [0, 0, 0, 0, 1, 2, 3, ..., 30, 31, 1, 2, 3, 4, 5, 6, 7]
	const flatResultArr = [
		...makePrevMonthArr(currentFullMonth.first_day_index),
		...currMonth,
		...nextMonth // this includes extra numbers that will be trimmed
	].slice(0, 7 * 6); // 7 days/week * 6 weeks

	// Chunk the flat array into slices of 7:
	const resultArr = [];
	for (let i = 0; i < 7; i++) {
		resultArr.push(flatResultArr.slice(i * 7, (i + 1) * 7));
	}
	return resultArr;
}

// print each cell its day number and color
function printMonthCalendarInDOM() {
	const monthArr = calcMonthCalendar();

	let currentMonthStarted = false;
	let currentMonthEnd = true;
	for (let i = 0; i < 6; i++) {
		let currentWeek = monthArr[i];
		//
		const week = document.querySelector("#table-body").children[i];
		for (let j = 0; j < 7; j++) {
			week.children[j].style.backgroundColor = "white";
			week.children[j].style.opacity = 1;
			// console.log(currentWeek[j].day);
			if (currentWeek[j].day === 1) {
				currentMonthStarted = true;
			}
			if (
				currentMonthEnd &&
				currentMonthStarted &&
				currentWeek[j].day === todayDate &&
				currentFullMonth.month_idx === todayMonth &&
				currentFullYear.year === todayYear
			) {
				let todayFullDate =
					state.todayYear +
					" " +
					(state.todayMonth + 1) +
					" " +
					state.todayDate;
				let isTodayHasNotes = notes.filter(note => note.date === todayFullDate);
				let viewNote = "";
				if (isTodayHasNotes.length > 0) {
					viewNote = `
							
							<br>
							<div style="width:max-content;">
							<i class="fas fa-sticky-note"></i>
							</div>
							<span class="tooltip"> ${isTodayHasNotes[0].title}</span>
						
							`;
					week.children[j].classList.add("tooltip-container");
				}
				// week.children[j].innerHTML = viewNote;
				// week.children[j].id = notesFound.id;

				week.children[
					j
				].innerHTML = `${currentWeek[j].day}<img  id="todayLogo" src='template/assets/img/logo SMS.png'  /> ${viewNote}`;
				// week.children[j].innerHTML = currentWeek[j].day;
				week.children[j].id = "current-day";
				week.children[j].classList.add("currMonth");
				week.children[j].style.backgroundColor = "#e1e1e1";
				currentMonthStarted = false;
				currentMonthEnd = false;
			} else {
				week.children[j].style.cursor = "";
				week.children[j].style.backgroundColor = "white"; //.style.backgroundColor = "white";
				week.children[j].style.color = "black";
				week.children[j].innerHTML = currentWeek[j].day;
				week.children[j].removeAttribute("id");
				if (currentWeek[j].state !== "currMonth") {
					week.children[j].style.backgroundColor = currentColor.value;
					week.children[j].style.opacity = 0.6;
					week.children[j].style.color = "rgba(255, 255, 255,0.4)";
					week.children[j].style.cursor = "default";
					week.children[j].classList.remove("currMonth");
					week.children[j].classList.remove("tooltip-container");
				}
				if (currentWeek[j].state == "currMonth") {
					//exp 2019 10 24
					week.children[j].classList.add("currMonth");
					let currentFullDate =
						currentFullMonth.year +
						" " +
						(currentFullMonth.month_idx + 1) +
						" " +
						currentWeek[j].day;
					let notesFound = notes.filter(
						note => note.date === currentFullDate
					)[0];
					if (notesFound) {
						let viewNote = `
						<td>
						<span class="day">${currentWeek[j].day}</span>
						<br>
						<div style="width:max-content;">
						<i class="fas fa-sticky-note"></i>
						</div>
						<span class="tooltip"> ${notesFound.title}</span>
					</td>
						`;
						week.children[j].innerHTML = viewNote;
						week.children[j].classList.add("tooltip-container");
						week.children[j].id = notesFound.id;
					} else {
						week.children[j].classList.remove("tooltip-container");
					}
				}
			}
			// console.log("xZx: ", currentWeek[j]);
		}
	}
}

function nextMonth() {
	state.todayMonth += 1;
	if (state.todayMonth == 12) {
		state.todayYear += 1;
		currentFullYear = analyizYear(state.todayYear);
		state.todayMonth = 0;
	}
	currentFullMonth = currentFullYear.months[monthsStr[state.todayMonth]];
	showCalenderInfo();
}

function prevMonth() {
	state.todayMonth -= 1;
	if (state.todayMonth == 0) {
		state.todayYear -= 1;
		currentFullYear = analyizYear(state.todayYear);
		state.todayMonth = 11;
	}
	currentFullMonth = currentFullYear.months[monthsStr[state.todayMonth]];
	showCalenderInfo();
}

function showCalenderInfo() {
	calenderMonthDOM.innerHTML = monthsStr[state.todayMonth];
	calenderYearDOM.innerHTML = state.todayYear;
	printMonthCalendarInDOM();
}

// to change the year manually
calenderYearDOM.addEventListener("input", e => {
	let numberPattern = /\d+/g;
	let year = parseInt(e.target.innerHTML.match(numberPattern).join(""));
	if (
		e.target.innerHTML.match(numberPattern).join("").length > 3 &&
		typeof year === "number"
	) {
		currentFullYear = analyizYear(year);
		currentFullMonth = currentFullYear.months[monthsStr[state.todayMonth]];
		state.todayYear = year;
		showCalenderInfo();
	}
});

let isModalOpen = false;

function openModal(isNote = false) {
	isModalOpen = true;
	popup.classList.remove("fade-out");
	modal.style.display = "block";

	isNote
		? (noteModal.style.display = "flex")
		: (colorModal.style.display = "flex");
	popup.classList.add("fade-in");
}
closeModal();
function closeModal() {
	isModalOpen = false;
	popup.classList.remove("fade-in");
	popup.classList.add("fade-out");
	deleteBtnInPopup.style.display = "inline";
	noteTitleInput.value = "";
	noteContentInput.value = "";
	document.getElementById("warning").innerHTML = "";
}


//Create,Read,Update Delete a Note!
//this is event delegation where we select a parent container that will have new cells
document.body.addEventListener("click", e => {
	let noteDate;
	let noteId;
	let note;
	let verbWord;
	if (e.target.parentElement.parentElement.id == "table-body") {
		if (e.target.classList.contains("tooltip-container")) {
			verbWord = "Edit";
			// deleteBtnInPopup.style.display = "display";
			noteId = e.target.id;
			console.log("noteId:", noteId);
			if (noteId == "current-day") {
				noteDate =
					state.todayYear +
					" " +
					(state.todayMonth + 1) +
					" " +
					state.todayDate;
				note = notes.filter(n => n.date == noteDate);
			} else {
				note = notes.filter(n => n.id == noteId);
			}
			console.log("note:", note);
			noteDate = note[0].date;
			openModal(true);
			fillNotePopup(note[0]);
			addNote(noteDate.split(" ")[2], noteId);
		} else if (e.target.classList.contains("currMonth")) {
			noteId = e.target.id;
			noteDate = e.target.innerHTML;
			if (noteId == "current-day") {
				noteDate = state.todayDate;
			}
			console.log("Add New Note");
			verbWord = "Create";
			//delete two below
			// noteDate =
			// 	currentFullMonth.year +
			// 	" " +
			// 	currentFullMonth.month +
			// 	" " +
			// 	e.target.innerHTML;
			console.log("zZz");

			openModal(true);
			addNote(noteDate, noteId);
			deleteBtnInPopup.style.display = "none";
		} else {
			console.log("Not Applicable for previous and next month");
		}
		noteDateInPopup.innerHTML = noteDate;
		verb.innerHTML = verbWord;
	} else if (e.target.classList.contains("fa-sticky-note")) {
		verbWord = "Edit";
		// deleteBtnInPopup.style.display = "display";

		console.log("edit note (sticky)");
		noteId = e.target.parentElement.parentElement.id;
		if (noteId == "current-day") {
			noteDate =
				state.todayYear + " " + (state.todayMonth + 1) + " " + state.todayDate;
			note = notes.filter(n => n.date == noteDate);
		} else {
			note = notes.filter(n => n.id == noteId);
		}
		// note = notes.filter(n => n.id == noteId);
		noteDate = note[0].date;
		console.log("note:", note);
		openModal(true);
		fillNotePopup(note[0]);
		noteDateInPopup.innerHTML = noteDate;
		verb.innerHTML = verbWord;

		console.log("xXx");
		addNote(noteDate.split(" ")[2], noteId);
	}
});

function fillNotePopup(note) {
	noteTitleInput.value = note.title;
	noteContentInput.value = note.desc;
}

var getSelectedNoteDay;
var getSelectedNoteId;

function addNote(noteDateDay, noteDateId) {
	getSelectedNoteDay = noteDateDay;
	getSelectedNoteId = noteDateId;
}

saveBtnInPopup.addEventListener("click", () => {
	const noteDate =
		currentFullMonth.year +
		" " +
		(currentFullMonth.month_idx + 1) +
		" " +
		getSelectedNoteDay;
	let oldNote = notes.filter(note => note.date == noteDate)[0];
	if (oldNote) {
		notes = notes.filter(note => oldNote.id !== note.id);
	}

	const newNote = {
		id: Math.random(),
		title: noteTitleInput.value,
		desc: noteContentInput.value,
		date: noteDate
	};

	if (
		noteTitleInput.value.trim() !== "" &&
		noteTitleInput.value.trim() !== " " &&
		(noteContentInput.value.trim() !== "" &&
			noteContentInput.value.trim() !== " ")
	) {
		console.log("newNote:", newNote);
		notes.push(newNote);
		closeModal(true);
		printMonthCalendarInDOM();
		updateLocalStorage();
	} else {
		document.getElementById("warning").innerHTML = "Please fill all fields";
	}
});

// delete note
deleteBtnInPopup.addEventListener("click", () => {
	if (getSelectedNoteId == "current-day") {
		noteDate =
			state.todayYear + " " + (state.todayMonth + 1) + " " + state.todayDate;
		notes = notes.filter(note => note.date !== noteDate);
		document
			.getElementById("current-day")
			.classList.remove("tooltip-container");
	} else {
		notes = notes.filter(note => note.id !== parseFloat(getSelectedNoteId));
	}
	updateLocalStorage();
	closeModal(true);
	printMonthCalendarInDOM();
});

//things i regret about this project:
//1- i didnt use a design pattern !
//2- i used date object as a string instead of date formate in notes
//3- as the feauters progress i end up with a spagheti code ! sorry :(
// FACT: it wouldn't be possible without the builtin date object "new Date()" thanks javascript !

</script>



