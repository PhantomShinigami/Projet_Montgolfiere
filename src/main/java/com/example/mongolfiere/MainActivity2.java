package com.example.mongolfiere;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MainActivity2 extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        Button btn_close;
        Button btn_open;

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main2);
        //pour le bouton retour
        btn_close = (Button) findViewById(R.id.button2);

        btn_close.setOnClickListener(new View.OnClickListener() {
            @Override

            public void onClick(View v) {
                finish();
            }
        });

        btn_open = (Button) findViewById(R.id.button3);

        btn_open.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity2.this, MainActivity3.class);
                startActivity(intent);
            }
        });

        btn_open = (Button) findViewById(R.id.button3);

        btn_open.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity2.this, MainActivity3.class);
                startActivity(intent);
            }
        });
        btn_open = (Button) findViewById(R.id.button4);

        btn_open.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity2.this, MainActivity4.class);
                startActivity(intent);
            }
        });
        btn_open = (Button) findViewById(R.id.button5);

        btn_open.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity2.this, MainActivity5.class);
                startActivity(intent);
            }
        });
        btn_open = (Button) findViewById(R.id.button6);

        btn_open.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity2.this, MainActivity6.class);
                startActivity(intent);
            }
        });
    }
}