package com.example.mongolfiere;

import androidx.appcompat.app.AppCompatActivity;

import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

public class MainActivity3 extends AppCompatActivity {
    TextView text, errorText;
    Button show;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main3);

        text=(TextView)findViewById(R.id.textView);
        errorText=(TextView)findViewById(R.id.textView2);
        show=(Button)findViewById(R.id.button);

        show.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
              new Task().execute();
            }
        });
    }
       class Task extends AsyncTask<Void, Void, Void>
       {
           String records="", error="";

           @Override
           protected Void doInBackground(Void... voids) {
               try{
                    Class.forName("com.mysql.jdbc.Driver");
                   Connection connection= DriverManager.getConnection("jdbc:mysql://192.168.107.136:3306/projet?useUnicode=true&characterEncoding=utf-8","usersnir2","projetmontgolfiere");
                   Statement statement=connection.createStatement();
                   ResultSet resultSet= statement.executeQuery("SELECT * FROM capteur");

                   while(resultSet.next()){
                       records += resultSet.getString(1) + " : " + resultSet.getString(2) + " " + resultSet.getString(3)+"\n"+"\n"+"\n" ;
                   }
               }
               catch(Exception e){
                   error= e.toString();
               }
               return null;

           }

           @Override
           protected void onPostExecute(Void aVoid) {
               text.setText(records);
               if(error !="")
                   errorText.setText(error);
               super.onPostExecute(aVoid);
           }
       }
}