package com.chatbot2.chatBot2;

import static org.junit.Assert.assertNotNull;

import java.net.MalformedURLException;
import java.util.ArrayList;

import org.junit.Test;

public class ProjectTest {

	@Test
	public void testIntegration() throws MalformedURLException
	{
		String location = "Dublin";
		
		GeoLocator geoLocator = new GeoLocator(location);
		ArrayList<String> coordinates = geoLocator.Coordinates();

		Weather weather = new Weather(coordinates.get(0), coordinates.get(1));
		int temperature = weather.RequestedTemperature(1);
		/*
		 * Checks if a temperature is obtained by the weather API (OWM) by checking if a temperature is calculated
		 * by the GeoLocator and the Weather class. If it is NOT Null, then it means that the two classes are 
		 * successfully communicating between themselves and that a value is being return by the classes and no
		 * errors are found.
		 */
		assertNotNull(temperature);
	}

}
