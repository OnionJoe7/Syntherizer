let audioContext = new (window.AudioContext || window.webkitAudioContext)();
let oscList = [];
let mainGainNode = null;
let keyboard = document.querySelector(".keyboard");                    //container element for keys
//let volumeControl = document.querySelector("input[name='volume']");    //HTMLElement("input") used to control the main audio volume
let noteFreq = null;                                                   //An array of arrays. Each one has a separate entry for each note in that octave. The frequency of the note's tone in Hertz is represented by the value for each. 
let customWaveform = null;                                             //domxref("PeriodicWave") - describes the waveform to use when the user selects "Custom" from the waveform picker
let sineTerms = null;                                                  //sineTerms / cosineTerms will be used to store the data for generating the waveform. Each contains an array that is generated when the user chooses "Custom"
let cosineTerms = null;
let btn = document.getElementById("register-form-submit");
let btn2 = document.getElementById("record-form-submit");
let sequence = [];







function createNoteTable() {
    let noteFreq = [];
    for (let i=0; i< 9; i++) {
      noteFreq[i] = [];
    }
  

    noteFreq[5]["B"] = 987.766602512248223;
    noteFreq[6]["C"] = 1046.502261202394538;
    noteFreq[6]["C#"] = 1108.730523907488384;
    noteFreq[6]["D"] = 1174.659071669630241;
    noteFreq[6]["D#"] = 1244.507934888323642;
    noteFreq[6]["E"] = 1318.510227651479718;
    noteFreq[6]["F"] = 1396.912925732015537;
    noteFreq[6]["F#"] = 1479.977690846537595;
    noteFreq[6]["G"] = 1567.981743926997176;
    noteFreq[6]["G#"] = 1661.218790319780554;

    noteFreq[6]["C"] = 1046.502261202394538;
    noteFreq[6]["C#"] = 1108.730523907488384;
    noteFreq[6]["D"] = 1174.659071669630241;
    noteFreq[6]["D#"] = 1244.507934888323642;
    noteFreq[6]["E"] = 1318.510227651479718;
    noteFreq[6]["F"] = 1396.912925732015537;
    noteFreq[6]["F#"] = 1479.977690846537595;
    noteFreq[6]["G"] = 1567.981743926997176;
    noteFreq[6]["G#"] = 1661.218790319780554;
    noteFreq[6]["A"] = 1760.000000000000000;
    noteFreq[6]["A#"] = 1864.655046072359665;
    noteFreq[6]["B"] = 1975.533205024496447;
    return noteFreq;
  }


  if (!Object.entries) {
    Object.entries = function entries(O) {
        return reduce(keys(O), (e, k) => concat(e, typeof k === 'string' && isEnumerable(O, k) ? [[k, O[k]]] : []), []);
    };
}

// Create the keyboard
  function setup() {
    noteFreq = createNoteTable();     // Create table which maps names and octaves to their frequencies
  
    //volumeControl.addEventListener("change", changeVolume, false);      //Event handle. 
  
    mainGainNode = audioContext.createGain();
    mainGainNode.connect(audioContext.destination);
    mainGainNode.gain.value = 0.2;
  
    // Create the keys; skip any that are sharp or flat; they are not needed. Each octave is inserted into a <div> of class "octave".
  
    noteFreq.forEach(function(keys, idx) {
      let keyList = Object.entries(keys);
      let octaveElem = document.createElement("div");
      octaveElem.className = "octave";
  
      keyList.forEach(function(key) {
        if (key[0].length == 1) {
          octaveElem.appendChild(createKey(key[0], idx, key[1]));
        }
      });
  
      keyboard.appendChild(octaveElem);
    });
  
    document.querySelector("div[data-note='B'][data-octave='5']").scrollIntoView(false);
  
    sineTerms = new Float32Array([0, 0, 1, 0, 1]);
    cosineTerms = new Float32Array(sineTerms.length);
    customWaveform = audioContext.createPeriodicWave(cosineTerms, sineTerms);
  
    for (i=0; i<9; i++) {
        oscList[i] = {};
    }
  }
  
  setup();




  function createKey(note, octave, freq) {
    let keyElement = document.createElement("div");
    let labelElement = document.createElement("div");
  
    keyElement.className = "key";
    keyElement.dataset["octave"] = octave;
    keyElement.dataset["note"] = note;
    keyElement.dataset["frequency"] = freq;
  
    labelElement.innerHTML = note + "<sub>" + octave + "</sub>";
    keyElement.appendChild(labelElement);
  
    keyElement.addEventListener("mousedown", notePressed, false);
    keyElement.addEventListener("mouseup", noteReleased, false);
    keyElement.addEventListener("mouseover", notePressed, false);
    keyElement.addEventListener("mouseleave", noteReleased, false);
  
    return keyElement;
  }


  function playTone(freq) {
  let osc = audioContext.createOscillator();
  osc.connect(mainGainNode);


  osc.frequency.value = freq;
  osc.start();

  return osc;
}


function playTone(freq) {
    let osc = audioContext.createOscillator();
    osc.connect(mainGainNode);
  
    let type = 'square'  //wavePicker.options[wavePicker.selectedIndex].value;
  
  
  
    osc.frequency.value = freq;
    osc.start();
  
    return osc;
  }

function notePressed(event) {
  if (event.buttons & 1) {
    let dataset = event.target.dataset;

    if (!dataset["pressed"]) {
      let octave = +dataset["octave"];
      oscList[octave][dataset["note"]] = playTone(dataset["frequency"]);
      dataset["pressed"] = "yes";
    }
  }
}

  function noteReleased(event) {
    let dataset = event.target.dataset;
    
    if (dataset && dataset["pressed"]) {
      let octave = +dataset["octave"];
      oscList[octave][dataset["note"]].stop();
      sequence.push(dataset["note"]);
      delete oscList[octave][dataset["note"]];
      delete dataset["pressed"];
      // console.log(sequence);
    }
  }



  function changeVolume(event) {
    mainGainNode.gain.value = volumeControl.value
  }


// console.log(sequence);

btn2.addEventListener('click', () => {
  sequence = []

})



btn.addEventListener('click', () => {
  function ajupload(){
    $.ajax({
        type: "POST",
        url: "UploadCredentials.php",
        data: {"id" : 1, "cleaned" : JSON.stringify(cleaned), "username" : username,"password" : password},
        success: function (data) 
          {
            alert('User registered!')
            window.location.href = '../Login/login.php'
          }
    })
  }
  
  let username = document.getElementById("username-field").value;
  let password = document.getElementById("password-field").value;
  let password2 = document.getElementById("password2-field").value;

  var cleaned = sequence.join('');
  // console.log(username, password)
  

  if (password2 != password) {
    alert('Passwords must match');
    location.reload()
  }
  if (password.length < 8 ) {
    alert('Password must be longer than 8');
    location.reload()
  }
  if (cleaned.length < 8){
    alert('Melody must be longer than 8.');
    alert('Please try again');
    sequence = [];
    

  }
  else{
  
  $.ajax
    ({
        type: "POST",
        url: "CheckDupes.php",
        data: {"id" : 1, "cleaned" : JSON.stringify(cleaned), "username" : username,"password" : password},
        success: function (data) 
        {
          if ($.trim(data) == 'nothing' ) {
          ajupload() }
          
          if ($.trim(data) == 'something' ) {
          alert('Username already exists. Try again')
          location.reload()
        }
         
        },
        error: function(xhr, ajaxOptions, thrownerror) { }
          // window.location../Login/login.php
        
    });
}});

function popup(){
  window.location.href='../Login/login.php';
}

