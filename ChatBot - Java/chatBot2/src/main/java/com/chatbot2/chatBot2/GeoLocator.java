package com.chatbot2.chatBot2;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;

public class GeoLocator 
{
	// Attributes
	private final String BODY = "http://api.openweathermap.org/geo/1.0/direct?q=";
	private final String API_KEY = "&appid=8fe0a86b1d08f7b8246e13ca39cf3b4e";
	private final String LIMIT = "&limit=1";
	private String LOCATION;
	private URL url;
	private StringBuilder result;
	
	//	Constructor
	public GeoLocator(String location) throws MalformedURLException 
	{
		this.LOCATION = location;
		this.url = new URL(BODY+LOCATION+LIMIT+API_KEY);
	}
	
	public StringBuilder DataRequest() 
	{
		try 
		{
			result = new StringBuilder();
			URLConnection connection = url.openConnection();
			BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
			String line;


			while ((line = reader.readLine()) != null) 
			{
				result.append(line);
			}
			reader.close();
		} 
		catch (Exception e) 
		{
			System.out.println("Error = " + e);
		}
		return result;
	}
	
	public ArrayList<String> Coordinates() 
	{
		StringBuilder data = DataRequest();

		//	Extracting information
		String result = data.toString();

		ArrayList<String> coordinates = new ArrayList<>();
		//	Eliminate unnecessary information from the URL request
		String cleanBody[] = result.split("},\"lat\":");
		String CleanEnd[] = cleanBody[1].split(",\"country\":");
		String coords[] = CleanEnd[0].split(",\"lon\":");

		/*
		 * Index Zero only stores Latitude and Index 1 only stores Longitude
		 */
		coordinates.add(coords[0]);
		coordinates.add(coords[1]);
		return coordinates;
	}
}
