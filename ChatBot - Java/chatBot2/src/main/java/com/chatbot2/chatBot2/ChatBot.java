package com.chatbot2.chatBot2;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.net.MalformedURLException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.temporal.ChronoUnit;
import java.util.ArrayList;
import java.util.Date;

import org.alicebot.ab.Bot;
import org.alicebot.ab.Chat;
import org.alicebot.ab.History;
import org.alicebot.ab.MagicBooleans;
import org.alicebot.ab.MagicStrings;
import org.alicebot.ab.utils.IOUtils;

public class ChatBot 
{
	// Attributes
	private static final boolean TRACE_MODE = false;
	private static String botName;
	private String resourcesPath;
	private Bot bot;
	private Chat chatSession;
	String userInput;
	private static final String greeting = "Robot : Hi, I heard you're going on holiday? Do you want some help planning your wardrobe?";
	private ArrayList<ArrayList<String>> list = new ArrayList<ArrayList<String>>(); // use ArrayList to hold location and date information
	final String DATE_FORMAT = "dd-MM-yyyy";


	//	Constructor set up the bot
	public ChatBot() 
	{
		this.botName = "super";
		this.resourcesPath = getResourcesPath();
		MagicBooleans.trace_mode = TRACE_MODE;
		this.bot = new Bot(botName, resourcesPath);
		this.chatSession = new Chat(bot);
		bot.brain.nodeStats();
	}


	// Add getters for testing purposes
	public String getGreeting() {
		return this.greeting;
	}


	// Methods
	// Greeting method - to give the user the option to use the chat bot or not
	public boolean greeting(){
		System.out.println(greeting);
		System.out.print("Human : "); 
		userInput = IOUtils.readInputTextLine().trim();
		if (userInput.equalsIgnoreCase("yes") || userInput.equalsIgnoreCase("y")) {
			System.out.println("Robot : That's great! Where would you like to go first?");
			return true;
		} else if (userInput.equalsIgnoreCase("no") || userInput.equalsIgnoreCase("n")){
			System.out.println("Robot : Hopefully I can help another time. Chat later!");
			return false;
		} else {
			System.out.println("Robot : Are you sure you don't want help? If you do, please answer yes or y.");
			userInput = IOUtils.readInputTextLine().trim();
			if (userInput.equalsIgnoreCase("yes") || userInput.equalsIgnoreCase("y")) {
				System.out.println("Robot : That's great! Where would you like to go first?");
				return true;
			}
			System.out.println("Robot : Hopefully I can help another time. Chat later!");
			return false;
		}
	}

	//	Get's the path to the resource folder located in the project
	public static String getResourcesPath() 
	{
		File currentDirectory = new File(".");
		//	Gets the full path of the current directory
		String path = currentDirectory.getAbsolutePath();
		path = path.substring(0, path.length() - 2);
		System.out.println(path);
		//	Location to where the Bot's resources are saved in the Java Project
		String resourcesPath = path + File.separator + "src" + File.separator + "main" + File.separator + "resources";
		return resourcesPath;
	}


	public Boolean cityValidation(String userInput) throws IOException 
	{
		File citiesText = new File(".");
		String path = citiesText.getAbsolutePath();
		path = path.substring(0, path.length() - 2);
		//	Location to where the city list text is saved in the Java Project
		String resourcesPath = path + File.separator + "src" + File.separator + "main" + File.separator + "resources" + File.separator + "bots" + File.separator + "super" + File.separator + "config" + File.separator + "citylist.txt";
		File readCityList = new File(resourcesPath);
		//	Buffer will read every single city in the text file
		BufferedReader br = new BufferedReader(new FileReader(readCityList));
		String str;
		//	Loops through the whole city list text to find a match, if return false it means user input is not a valid city
		while ((str = br.readLine()) != null) 
		{
			if (str.equalsIgnoreCase(userInput)) 
			{
				br.close();
				return true;
			} 
		}
		br.close();
		return false;
	}


	public String wildCharactersValidation(String response)
	{
		/*	Loops checks if response contains any wild characters that is not readable for the user
		 * 	The AIML file response template is full of wild characters, before displaying bot's response
		 * 	to the user we first check for those characters and replace it with appropriate meaning
		 */	
		while (response.contains("&lt;"))
		{
			response = response.replace("&lt;", "<");
		}
		while (response.contains("&gt;"))
		{
			response = response.replace("&gt;", ">");
		}
		while (response.contains("slash"))
		{
			response = response.replace("slash", "/");
		}
		while (response.contains("dash"))
		{
			response = response.replace("dash", "-");
		}
		return response;
	}

	// Loop to check if the arrayList contains the location
	public boolean checkArrayLocation(String userInput){
		for(int i = 0; i < list.size(); i++) {
			if (list.get(i).get(0).contains(userInput)) {
				return true; 
			}
		}
		return false; 		
	}

	// Loop to find the index of the array that contains the location
	public int findArrayLocation(String userInput) {
		int location = 0; 
		for(int i = 0; i < list.size(); i++) {
			if(list.get(i).get(0).contains(userInput)) {
				location = i; 
			}
		}
		return location; 
	}


	// Add the location to the arrayList
	public boolean addLocationToList(String userInput) {
		if (!checkArrayLocation(userInput)) {
			list.add(new ArrayList<String>()); 
			list.get(list.size() - 1).add(userInput);
			return true; 
		}
		return false; 
	}

	// Hard Code to ask the user for a date
	public String whatDate() {
		String userInput = IOUtils.readInputTextLine(); 
		userInput = returnValidDate(userInput); 
		return userInput; 
	}

	// Date Validation
	public boolean dateValidation(String date) { 
		try {
			DateFormat df = new SimpleDateFormat(DATE_FORMAT);
			df.setLenient(false);
			df.parse(date);
			return true;
		} catch (ParseException e) {
			return false;
		}
	}

	// Convert the valid date to correct format
	public String returnValidDate(String date) {
		date = date.replace('/', '-');
		date = date.replace('.', '-'); 
		return date; 
	}

	// Add Date to ArrayList
	public boolean addDateToArrayList(int location, String date) {
		if (list.get(location).add(date)) {
			return true;
		} else {
			return false; 
		}
	}

	// Question to exit the do while loop
	// Method 6: 
	public boolean exitLoop() throws MalformedURLException, ParseException 
	{
		System.out.println("Robot : Would you like to go somewhere else?");
		System.out.print("Human : ");
		String userAnswer = IOUtils.readInputTextLine().trim(); 
		while (!userAnswer.toLowerCase().equals("yes") && !userAnswer.toLowerCase().equals("no")) {
			System.out.println("Robot : Sorry, I didn't get that. Could you answer yes or no please?");
			System.out.print("Human : ");
			userAnswer = IOUtils.readInputTextLine(); 
		}

		if (userAnswer.equalsIgnoreCase("yes")) {
			System.out.println("Robot : That's great, where else would you like to go?");
			return false; 
		} else  {
			System.out.println("Robot : It sounds like you have your holiday planned out! Let me generate some fab wardrobe suggestions!");
			/*
			 * First loop gets location, second loop gets the date on a given location
			 */
			for (int i = 0; i < list.size(); i++) 
			{
				/*
				 * GeoLocator takes the name of the city and gets the latitude and longitude so
				 * we can forecast the temperature in a seven days range
				 */
				GeoLocator geoLocator = new GeoLocator(list.get(i).get(0));
				ArrayList<String> coordinates = geoLocator.Coordinates();
				String latitude = coordinates.get(0);
				String longitude = coordinates.get(1);
				for (int j = 1; j < list.get(i).size(); j++) 
				{
					long getDayDifference = NumberOfDays(list.get(i).get(j));
					int day = (int) getDayDifference; 

					Weather weather = new Weather(latitude, longitude);
					int temperature = weather.RequestedTemperature(day);
					System.out.println("Robot : " + "Temperature in " + list.get(i).get(0) + " for " + list.get(i).get(j) + " is " + temperature + " C");
					String suggestion = ClothesSuggestions(temperature);
					System.out.println(suggestion);
				}

			}
		}
		return true;
	}
	/*
	 * Change the AskBot() method.
	 * This method will now return the userInput as a String which will be used in the runBot() method. 
	 * It will no longer try to follow a loop pattern from an AIML file. 
	 */
	//	Bot takes user input and goes through it AIML document to find an answer, then send back a response
	public String AskBot() throws IOException 
	{
		String botAnswer ="";
		System.out.print("Human : ");

		userInput = IOUtils.readInputTextLine();

		//	Checks if input is empty or null. If it is, then do not let the Bot send a response
		if ((userInput == null) || (userInput.length() < 1))
		{
			userInput = MagicStrings.null_input;
		}

		//	Condition to exit the loop/chat session based on user's input
		if (userInput.equals("q")) 
		{
			System.exit(0);
		} 
		else if (userInput.equals("wq")) 
		{
			bot.writeQuit();
			System.exit(0);
		} 
		else 
		{
			String request = userInput;
			//	Prints what is being talked between user and the Bot
			if (MagicBooleans.trace_mode)
			{
				System.out.println(
						"STATE=" + request + ":THAT=" + ((History) chatSession.thatHistory.get(0)).get(0)
						+ ":TOPIC=" + chatSession.predicates.get("topic"));
			}
			//	This connects to the AIML doc and sends back a response based on what user asks 
			String response = chatSession.multisentenceRespond(request);

			//	Checks for wild characters
			response = wildCharactersValidation(response);

			System.out.println("Robot : " + response);
			//System.out.println(response);

			return request;

		}
		return botAnswer;
	}


	// Method to run the bot - comprised of multiple methods
	public boolean runBot() throws IOException, ParseException {
		// Method 1: Ask Bot - get the user input
		String input = AskBot(); 

		// Method 2: Validate the return string from AskBot, 
		// if it is a valid city (use the cityValidation method) add to the array

		// Refactor the if else to just put in a while loop 
		while(!cityValidation(input)) {
			input = AskBot(); 
		}

		// Check to see if the input value is already a value in the 2d array
		// If it is - break the loop 
		// If it isn't then create a new ArrayList within the original ArrayList
		// Set the first value to input
		// Then add the city to the array
		
		addLocationToList(input);
		

		// Method 3: Hard code asking the user for a date, return it as a string
		System.out.print("Human : ");
		String whatDate = whatDate(); 
		int location; 

		// Method 4: Validate the date
		if(dateValidation(whatDate)) 
		{
			// Find the array with the userInput
			// Method 5: If date is valid get the index value of the location
			// Convert the date to correct format
			whatDate = returnValidDate(whatDate); 
			/*
			 * Since Weather API can only forecast 7 days ahead, we validate also check the day's
			 * difference between current day and the date input by the user
			 */
			long getDayDifference = NumberOfDays(whatDate);
			int day = (int) getDayDifference; 

			if (day > 7 || day < 0) 
			{
				do 
				{
					System.out.println("Robot : " + "I can only forecast weather information in a range of 7 days");
					System.out.println("Robot : " + "Unfortunately your date is pass my range, try a closer date");
					System.out.print("Human : ");
					whatDate = whatDate(); 
					//userInput = IOUtils.readInputTextLine();	
					getDayDifference = NumberOfDays(whatDate);
					day = (int) getDayDifference; 
				} while (day > 7 || day < 0);
			}
			location = findArrayLocation(input); 
			addDateToArrayList(location, whatDate);  
		} 
		else 
		{
			while(!dateValidation(whatDate)) 
			{
				System.out.println("Robot : Sorry, I didn't understand that. Please give me a date in the format DD-MM-YYYY!");
				System.out.print("Human : ");
				whatDate = whatDate(); 
			}
			whatDate = returnValidDate(whatDate); 
			location = findArrayLocation(input); 
			addDateToArrayList(location, whatDate); 
		}

		return exitLoop(); 
	}

	public static long NumberOfDays(String date) throws ParseException 
	{
		/*
		 * takes user input dd-MM-yyyy as a string and converts it into a date
		 * so it can be formatted to yyyy-MM-dd. Once converted we can use the 
		 * java method to calculate the number of days between to given dates
		 */
		SimpleDateFormat formatter = new SimpleDateFormat("dd-MM-yyyy");
		Date dateValue = formatter.parse(date);

		SimpleDateFormat output = new SimpleDateFormat("yyyy-MM-dd");
		String newDateString = output.format(dateValue);

		LocalDate requestedDay = LocalDate.parse(newDateString);
		LocalDate today = LocalDate.now(); 

		long numberOfDays = ChronoUnit.DAYS.between(today, requestedDay);		
		return numberOfDays;
	}

	public String ClothesSuggestions(int temperature) 
	{
		if (temperature < 10) 
		{
			return "Robot : I recommend you to pack gloves, warm hats, boots and heavy coats";
		} 
		else if (temperature < 18) 
		{
			return "Robot : I recommend you to pack long-sleeved shirts, light sweaters, shoes and light jackets";
		}
		else 
		{
			return "Robot : I recommend you to pack v-neck shirts, shorts, sandals and breathable fabrics";
		}
	}

}
