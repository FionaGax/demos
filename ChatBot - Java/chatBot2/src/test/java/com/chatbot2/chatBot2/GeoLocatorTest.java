package com.chatbot2.chatBot2;

import static org.junit.Assert.*;

import java.net.MalformedURLException;
import java.util.ArrayList;

import org.junit.Test;



public class GeoLocatorTest 
{
	
	/*
	 * Test Case: Checking if API gives back a response after a location call
	 */
	@Test
	public void testDataRequest() throws MalformedURLException
	{
		//	Dublin coordinates
		GeoLocator geoLocator = new GeoLocator("Dublin");
		StringBuilder  actual = geoLocator.DataRequest();
		boolean isEmpty = actual.toString().isEmpty();
		assertFalse(isEmpty);
	}
	
	/*
	 * Test Case: Checks if latitude and longitude are stored in the ArrayList by checking 
	 * its size. It stores latitude and longitude, so size must be 2
	 */
	@Test
	public void testCoordinates() throws MalformedURLException
	{
		//	Dublin coordinates
		GeoLocator geoLocator = new GeoLocator("Dublin");
		ArrayList<String> coordinates = geoLocator.Coordinates();
		int  actual = coordinates.size();
		int expected = 2;
		assertEquals(expected, actual);
	}

}
