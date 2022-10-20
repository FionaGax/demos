package com.chatbot2.chatBot2; 

import java.io.IOException;
import java.text.ParseException;

public class Main{

	public static void main(String[] args) throws IOException, ParseException {


		// Create the aiml file from the citylist.txt file
		AIMLCreator newFile = new AIMLCreator("citylist.txt");
		newFile.readFile(); 
		newFile.writeFile();

		// Create the bot
		ChatBot bot = new ChatBot(); 

		//	Adding back the while loop as it was causing issues with user input
		if(bot.greeting()) {
			do {
				bot.runBot();
			} while (!bot.runBot()); 
		}
	}
}


