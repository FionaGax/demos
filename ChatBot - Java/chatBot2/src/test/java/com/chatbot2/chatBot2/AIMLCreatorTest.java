package com.chatbot2.chatBot2;

import static org.junit.Assert.*;

import java.io.File;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;

import org.junit.Test;

public class AIMLCreatorTest {

	/*
	 Test One: 
	 Ensure that there is no file (in this case called locations) in the aiml directory
	 Note - if the main class has been run then the file will be created and this test will fail
	 But before the class was created this location file did not exist which makes this a valid test case
	 */
	@Test
	public void testFileDoesNotExist() {
		// Create the new bot
		ChatBot bot = new ChatBot(); 
		// File that I will use to create the AIML file will be part of the AIMLCreator constructor
		AIMLCreator file = new AIMLCreator("citylist.txt"); 

		// Path to where the file should be
		file.setFileName();
		Path path = Paths.get(file.getPrintFileToPath() + file.getFileName() + ".aiml"); 
		boolean isTrue = Files.notExists(path); 
		assertTrue(isTrue); 
	}

	/*
	 Test Two: 
	 Test to ensure that the filepath for the .txt file is correct
	 */

	@Test
	public void testFilePathForTXTIsCorrect() {
		// Path for the file in question 'citylist.txt'
		// This is the code that will be generating the location in the class
		String fileLocation = ChatBot.getResourcesPath() + File.separator + "bots" + File.separator + "super" + File.separator + "config" + File.separator + "citylist.txt";
		// Ensure to escape the escapes so the string is read correctly
		// This is the location when you're reading down the files
		String actualLocation = ChatBot.getResourcesPath() + "\\bots\\super\\config\\citylist.txt";
		assertEquals(fileLocation, actualLocation);
	}


	/*
	 Test Three: 
	 Test to ensure that the setFileName() method will remove the .txt from the 
	 file name so it will work correctly in the aiml directory
	 */

	@Test
	public void testSetFileName() {
		AIMLCreator test = new AIMLCreator("citylist.txt"); 
		String expected = "locations"; 
		test.setFileName();
		String actual = test.getFileName();
		assertEquals(expected, actual); 
	}

	/*
	 Test Four: 
	 Test to ensure that the file is created
	 */

	@Test
	public void testFileIsCreated() {
		AIMLCreator test = new AIMLCreator("citylist.txt"); 
		test.writeFile(); 
		Path path = Paths.get(test.getPrintFileToPath() + test.getFileName() + ".aiml"); 
		boolean isTrue = Files.exists(path); 
		assertTrue(isTrue); 
	}

	/*
	 Test Five: 
	 Test to ensure that the file is created in the correct Directory - file path must be correct
	 */

	@Test
	public void testFileInCorrectDirectory() {
		// Path for the file in question 'citylist.txt'
		String fileLocation = ChatBot.getResourcesPath() + File.separator + "bots" + File.separator + "super" + File.separator + "aiml" + File.separator + "citylist.aiml";
		// Ensure to escape the escapes so the string is read correctly
		String actualLocation = ChatBot.getResourcesPath() + "\\bots\\super\\aiml\\citylist.aiml";
		assertEquals(fileLocation, actualLocation);
	}
	
	/*
	 Test Six: 
	 Test to ensure that the AIMLCreator Constructor works correctly - as in creates an instance of AIMLCreator object
	 */
	
	@Test
	public void testConstructor() {
		AIMLCreator test = new AIMLCreator("citylist.txt"); 
		assertTrue(test instanceof AIMLCreator); 
	}

	/* 
	 Test Seven: 
	 Test the readFile method is working correctly. 
	 Check the file that will be used in the constructor and ensure that the actual int in the test case is the amount of lines in that file
	 as this will change when more locations are added to it. 
	 When this test case was written there were 1894 locations in the file but this will change. 
	 */

	@Test
	public void testReadFile() {
		AIMLCreator test = new AIMLCreator("citylist.txt"); 
		test.readFile();
		int expected = 1894; 
		int actual = test.getListSize();
		assertEquals(expected, actual); 
	}

}
