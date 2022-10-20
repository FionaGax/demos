package com.chatbot2.chatBot2.AttemptedGUI;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.TextArea;
import javafx.scene.control.TextField;

public class Controller {
	
	@FXML
	private TextArea outputText;
	@FXML
	private TextField inputText;
	@FXML
	private Button sendButton;
	
	public void submit(ActionEvent e) 
	{
		String userText = inputText.getText();
		outputText.appendText(userText + "\n");
		inputText.setText("");
		System.out.println(userText);
	}
}
