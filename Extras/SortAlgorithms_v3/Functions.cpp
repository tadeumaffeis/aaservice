#include <iostream>
#include <cstdlib>
#include <ctime>
#include <iomanip>
#include <Windows.h>

void swap(long vet[], long a, long b)
{
    if (a == b)
    {
        return;
    }
	long aux = vet[a];
	vet[a] = vet[b];
	vet[b] = aux;
}

void loadRandValues(long vet[], long size, long limit)
{
	srand((unsigned int)time(NULL));
	for (int i = 0; i < size; i++)
	{
		vet[i] = (long)rand() % limit;
	}
}

void show(long vet[], long size)
{
	for (int i = 0; i < size; i++)
	{
		std::cout << std::setprecision(10) <<  vet[i] << " ";
	}
	std::cout << "\n";
}

void show_color(long vet[], long size, long pos_a, long pos_b)
{
	std::cout << std::endl;
	for (int i=0; i < size; i++)
	{
		if ((i == pos_a || i == pos_b) && pos_a != pos_b)
		{
			SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 4);
		}
		else
		{
			SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 2);
		}
		std::cout << std::setw(8) << vet[i] << " ";
	}
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 2);
}

void ShowLine(long vet[], long size)
{
    for (long i=0; i < size; i++)
    {
        std::cout << "vet[" << i << "] = " << std::setw(5) << vet[i] << std::endl;
    }
}
