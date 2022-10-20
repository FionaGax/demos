package com.chatbot2.chatBot2;

import static org.junit.Assert.*;

import java.io.IOException;
import java.net.MalformedURLException;
import java.text.ParseException;

import org.junit.Test;

public class ChatBotTest2UserInput {

	// Test Two: 
	// Test to check that yes is accepted, boolean should return true
	// The greeting method gives the user an option to proceed with the bot
	// - MOVED TO ChatBotTest2UserInput.java as this test requires userInput
	@Test
	public void greetingMethodTestForYesOrY() {
		ChatBot bot = new ChatBot();
		boolean b = bot.greeting(); // type yes or y for the boolean to be true
		assertTrue(b);
	}


	// Test Three: 
	// Test to check that no is accepted, boolean should return false
	// - MOVED TO ChatBotTest2UserInput.java as this test requires userInput
	@Test
	public void greetingMethodTestForNoOrN() {
		ChatBot bot = new ChatBot();
		boolean b = bot.greeting(); // type anything but yes or y for a false or for immediate false type no or n
		assertFalse(b);
	}


	/*
	 * Test One: 
	 * Test to see if I get back the correct string that I type in 
	 * // - MOVED TO ChatBotTest2UserInput.java as this test requires userInput
	 */
	@Test
	public void testAskMethodGetCorrectStringReturned() {
		ChatBot bot = new ChatBot(); 
		String actual = ""; 
		try {
			actual = bot.AskBot();  // Type Hello into the console and then go back to see if it is a green/red bar result
		} catch (IOException e) {
			fail(); 
		}
		String expected = "Hello"; 
		assertEquals(actual, expected); 

	}

	/*
	 * Test Nine: 
	 */
	@Test
	public void testWhatDate() {
		ChatBot bot = new ChatBot(); 
		String actual = bot.whatDate(); // Type 15/11/2022 to get a green bar
		String expected = "15/11/2022";
		assertEquals(actual, expected); 
	}


	/*
	 * Test Twenty-Five: 
	 * Test by answering 'yes'. Should return false; 
	 * - MOVED TO ChatBotTest2UserInput.java as this test requires userInput
	 */

	@Test
	public void testExitLoopFalse() throws MalformedURLException, ParseException{
		ChatBot bot = new ChatBot();
		boolean isFalse = false; 
		isFalse = bot.exitLoop(); // Type yes into console to test
		assertFalse(isFalse); 	
	}

	/*
	 * Test Twenty-Six: 
	 * Test by answering 'no'. Should return true
	 * - MOVED TO ChatBotTest2UserInput.java as this test requires userInput
	 */
	@Test
	public void testExitLoopTrue() throws MalformedURLException, ParseException{
		ChatBot bot = new ChatBot();
		boolean isTrue = false; 
		isTrue = bot.exitLoop(); // Type no into console to test
		assertTrue(isTrue); 	
	}
}
