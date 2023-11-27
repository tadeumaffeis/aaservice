#include <iostream>
extern void swap(int &a, int &b);
extern void printArray(int arr[], int size);

void selectionSort(int arr[], int n)
{
    for (int i = 0; i < n-1; i++)
    {
        // Encontra o índice do menor elemento no subarray não ordenado
        int indiceMenor = i;
        for (int j = i+1; j < n; j++)
        {
            //if (arr[j] < arr[indiceMenor]) {
            if (arr[i] > arr[j])    //indiceMenor = j;
            {
                swap(arr[i], arr[j]);
                printArray(arr, n);
            }
        }

        // Troca o elemento menor com o primeiro elemento não ordenado
        //swap(arr[i], arr[indiceMenor]);
    }
}


