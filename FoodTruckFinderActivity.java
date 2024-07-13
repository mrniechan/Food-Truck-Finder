package com.example.foodtruck;

import androidx.annotation.NonNull;
import androidx.fragment.app.FragmentActivity;
import android.os.Bundle;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.LatLngBounds;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class FoodTruckFinderActivity extends FragmentActivity implements OnMapReadyCallback {

    private static final int LOCATION_PERMISSION_REQUEST_CODE = 1;
    private GoogleMap mMap;
    private static final String URL = "http://10.0.2.2/FoodTruck/get_trucks.php"; // Use 10.0.2.2 for emulator or your local network IP for device

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_food_truck_finder);

        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
    }

    @Override
    public void onMapReady(@NonNull GoogleMap googleMap) {
        mMap = googleMap;

        if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED && ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // Request permissions
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION, Manifest.permission.ACCESS_COARSE_LOCATION}, LOCATION_PERMISSION_REQUEST_CODE);
        } else {
            mMap.setMyLocationEnabled(true);
            // Fetch food truck data only if permissions are granted
            fetchFoodTruckData();
        }

        // Set custom info window adapter
        mMap.setInfoWindowAdapter(new CustomInfoWindowAdapter(this));
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == LOCATION_PERMISSION_REQUEST_CODE) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED) {
                    mMap.setMyLocationEnabled(true);
                    fetchFoodTruckData();
                }
            } else {
                // Permission was denied. Display an error message or disable location-based features
                Log.d("FoodTruckFinder", "Location permission not granted");
            }
        }
    }

    private void fetchFoodTruckData() {
        RequestQueue queue = Volley.newRequestQueue(this);
        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, URL, null,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        Log.d("FoodTruckFinder", "Response: " + response.toString());
                        try {
                            LatLngBounds.Builder builder = new LatLngBounds.Builder();
                            for (int i = 0; i < response.length(); i++) {
                                JSONObject foodTruck = response.getJSONObject(i);
                                String name = foodTruck.getString("name");
                                double latitude = foodTruck.getDouble("latitude");
                                double longitude = foodTruck.getDouble("longitude");
                                String menu = foodTruck.getString("menu");
                                String schedule = foodTruck.getString("schedule");

                                Log.d("FoodTruckFinder", "Adding marker: " + name + " at " + latitude + ", " + longitude);

                                LatLng location = new LatLng(latitude, longitude);
                                Marker marker = mMap.addMarker(new MarkerOptions().position(location)
                                        .title(name)
                                        .snippet("Menu: " + menu + "\nSchedule: " + schedule));
                                builder.include(location);

                                if (marker == null) {
                                    Log.e("FoodTruckFinder", "Marker is null for: " + name);
                                }
                            }
                            // Move the camera to include all markers
                            LatLngBounds bounds = builder.build();
                            mMap.moveCamera(CameraUpdateFactory.newLatLngBounds(bounds, 100));
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Log.e("FoodTruckFinder", "JSON parsing error: " + e.getMessage());
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Log.e("FoodTruckFinder", "Error: " + error.toString());
            }
        });

        queue.add(jsonArrayRequest);
    }

    public class CustomInfoWindowAdapter implements GoogleMap.InfoWindowAdapter {

        private final View mWindow;
        private final Context mContext;

        public CustomInfoWindowAdapter(Context context) {
            mContext = context;
            mWindow = LayoutInflater.from(context).inflate(R.layout.custom_info_window, null);
        }

        private void renderWindowText(Marker marker, View view) {
            String title = marker.getTitle();
            TextView titleTextView = view.findViewById(R.id.info_window_title);
            if (title != null && !title.isEmpty()) {
                titleTextView.setText(title);
            } else {
                titleTextView.setText("");
            }

            String snippet = marker.getSnippet();
            TextView snippetTextView = view.findViewById(R.id.info_window_snippet);
            if (snippet != null && !snippet.isEmpty()) {
                snippetTextView.setText(snippet);
            } else {
                snippetTextView.setText("");
            }
        }

        @Override
        public View getInfoWindow(Marker marker) {
            renderWindowText(marker, mWindow);
            return mWindow;
        }

        @Override
        public View getInfoContents(Marker marker) {
            renderWindowText(marker, mWindow);
            return mWindow;
        }
    }
}
