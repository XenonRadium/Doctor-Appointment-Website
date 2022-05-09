function getBotResponse(input) {
    //Simple responses
    switch (input){
      case "hello": case "hi": case "sup": case "HI":
        return "Hello there!";
        break;
      case "bye": case "goodbye": case "bye bye": case "ciao":
        return "Talk to you later!";
        break; 
      case "doctor": case "Help": case "help": case "see doctor": case "details":
        var link = str.link("FindDoctor.php");
        return "Click here to view doctor details! > "+link;
        break;     
      case '1':
        var str = "Appointment";
        var link = str.link("AppointmentHistory.php");
        return "Click here to view appointment! > "+link;
        break;
      case '2':
        var str = "Doctor Information";
        var link = str.link("FindDoctor.php");
        return "Click here to view doctor details! > "+link;
        break;
      case '3':
        var str = "Map";
        var link = str.link("Map.php");
        return "Click here to find the doctor nearest to you! > "+link;
        break;
      default:
        return "Try asking something else!";
  }

}
