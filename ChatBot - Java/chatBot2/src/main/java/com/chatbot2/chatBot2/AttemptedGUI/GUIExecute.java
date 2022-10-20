package com.chatbot2.chatBot2.AttemptedGUI;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

public class GUIExecute extends Application {
	
	public static void main(String[] args) 
	{
		launch(args);
	}
	
	@Override
	public void start(Stage primaryStage) throws Exception {
		Parent root = FXMLLoader.load(getClass().getResource("StylesFX.fxml"));
		primaryStage.setTitle("ChatBot");
		primaryStage.setScene(new Scene(root));
		primaryStage.show();
	}

}
