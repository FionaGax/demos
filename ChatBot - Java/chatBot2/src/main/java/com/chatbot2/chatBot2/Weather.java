package com.chatbot2.chatBot2;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

public class Weather 
{
	//	Attributes
	private final String BODY = "https://api.openweathermap.org/data/2.5/onecall?lat=";
	private final String LATITUDE;
	private final String LONGITUDE;
	private final String EXCLUDE = "&exclude=current,minutely,hourly,alerts";
	private final String API_KEY = "&appid=8fe0a86b1d08f7b8246e13ca39cf3b4e";
	private final String UNITS = "&units=metric";
	private URL url;
	private StringBuilder result;

	//	constructor
	public Weather(String latitude, String longitude) throws MalformedURLException 
	{
		this.LATITUDE = latitude;
		this.LONGITUDE = "&lon="+longitude;
		this.url = new URL(BODY+LATITUDE+LONGITUDE+EXCLUDE+API_KEY+UNITS);
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
	
	/*
	 * This method extracts the day the user needs from a forecasted list of temperatures
	 * in a given location.
	 */
	public int RequestedTemperature(int day) 
	{
		ArrayList<String> forecastedTemperatures = ForecastTemperatures();
		
		//	Obtaining and parsing the String value temperature into a double data type
		double temperature = Double.parseDouble(forecastedTemperatures.get(day));
		int roundTemperature = (int) Math.round(temperature);
		
		return roundTemperature;
	}
	
	/*
	 * This method gets and stores the temperature for eight consecutive days.
	 * Stores each temperature value in an ArrayList
	 */
	public ArrayList<String> ForecastTemperatures() 
	{
		StringBuilder data = DataRequest();

		//	Extracting information
		Map<String, Object> resultToMap = jsonToMap(data.toString());
		String dataString = resultToMap.get("daily").toString();
		ArrayList<String> temperatureForecast = new ArrayList<>();
		//	Split the string on dt= so we can easily extract the temperature of a given day
		String arr[] = dataString.split("dt=");
		for (int i = 1; i < arr.length; i++) 
		{
			//	Extracts only the temperature in each day
			String[] cleaning = arr[i].split("day=");
			String[] temperatures = cleaning[1].split(", min=");
			temperatureForecast.add(temperatures[0]);
		}
		return temperatureForecast;
	}
	
	//	Method converts JSON objects into a Map String object for easier data extraction
	public static Map<String, Object> jsonToMap(String str)
	{
		Map<String, Object> map = new Gson().fromJson(str, new TypeToken<HashMap<String, Object>>() {}.getType());
		return map;
	}
}
