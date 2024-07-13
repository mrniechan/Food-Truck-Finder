package com.example.foodtruck;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

public class AboutUsActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_about_us);

        // Set up the toolbar
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        // Enable the back button
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
        }

        // Set the back button functionality
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
    }

    public void showPerson1Details(View view) {
        showDetailsDialog("Member 1", "Name: Nurul Izzah Bt Ajmal\nStudent Number: 2022961315\nProgramme Code: CS240", R.drawable.izah);
    }

    public void showPerson2Details(View view) {
        showDetailsDialog("Member 2", "Name: Nurul Musfirah Bt Badrul Hisham\nStudent Number: 2022947041\nProgramme Code: CS240", R.drawable.mus);
    }

    public void showPerson3Details(View view) {
        showDetailsDialog("Member 3", "Name: Azilatulhana Bt Mat Daud\nStudent Number: 2022798339\nProgramme Code: CS240", R.drawable.azie);
    }

    public void showPerson4Details(View view) {
        showDetailsDialog("Member 4", "Name: Marnie Umirah Bt Mazlan\nStudent Number: 2022798297\nProgramme Code: CS240", R.drawable.mar2);
    }

    private void showDetailsDialog(String title, String details, int imageResId) {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        LayoutInflater inflater = this.getLayoutInflater();
        View dialogView = inflater.inflate(R.layout.dialog_person_details, null);
        builder.setView(dialogView);

        TextView titleView = dialogView.findViewById(R.id.dialogTitle);
        TextView detailsView = dialogView.findViewById(R.id.dialogDetails);
        ImageView imageView = dialogView.findViewById(R.id.dialogImage);

        titleView.setText(title);
        detailsView.setText(details);
        imageView.setImageResource(imageResId);

        builder.setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int which) {
                // Do nothing
            }
        });

        builder.create().show();
    }

    public void openGitHub(View view) {
        Intent browserIntent = new Intent(Intent.ACTION_VIEW, Uri.parse("https://github.com/yourgithubrepository"));
        startActivity(browserIntent);
    }
}
